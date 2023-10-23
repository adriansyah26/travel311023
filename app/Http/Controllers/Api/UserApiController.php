<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    public function index()
    {
        try {
            $users = User::latest()->get();

            return Api::json($users, 200, 'User retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve User', false);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $user = User::create([
                'title' => $request->input('title'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password' => Hash::make('admin123'), // Set password default di sini
            ]);

            return Api::json($user, 201, 'User created successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to create user', false);
        }
    }

    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return Api::json([], 404, 'User not found', false);
            }

            return Api::json($user, 200, 'User retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve user', false);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $user = User::find($id);

            if (!$user) {
                return Api::json([], 404, 'User not found', false);
            }

            $user->title = $request->input('title');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->save();

            return Api::json($user, 200, 'User updated successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to update user', false);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return Api::json([], 404, 'User not found', false);
            }

            if ($user->delete()) {
                return Api::json([], 200, 'User deleted successfully');
            } else {
                return Api::json([], 500, 'Failed to delete user', false);
            }
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to delete user', false);
        }
    }

    public function updateChangePassword(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:8',
                'confirm_new_password' => 'required|same:new_password',
            ]);

            $validator->sometimes('confirm_new_password', 'different:old_password', function ($input) use ($request) {
                return !Hash::check($input->old_password, User::find($request->route('id'))->password);
            });

            if ($validator->fails()) {
                return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
            }

            $user = User::find($id);

            if (!$user || !Hash::check($request->old_password, $user->password)) {
                return Api::json([], 400, 'The old password does not match', false);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return Api::json([], 200, 'Password updated successfully', true);
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to update password', false);
        }
    }
}
