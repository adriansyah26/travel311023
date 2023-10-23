<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404); // Menghasilkan "Not Found" jika user tidak ditemukan
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan data ke database
            $user = User::create([
                'title' => $request->input('title'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password' => Hash::make('admin123'), // Set password default di sini
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Users created successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to created users'
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404); // Menghasilkan "Not Found" jika user tidak ditemukan
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        abort(404); // Menghasilkan "Not Found" jika user tidak ditemukan
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            Session::flash('success', 'Users deleted successfully');
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete user']);
        }
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Users not found',
            ]);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function updateUser(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'titleedit' => 'required',
            'first_name_edit' => 'required',
            'last_name_edit' => 'required',
            'phoneedit' => 'required',
            'emailedit' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
            ], 400);
        }

        try {
            // Mencari User berdasarkan ID
            $user = User::findOrFail($userId);

            // Jika user tidak ditemukan, kirim respons error
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            // Memperbarui data user
            $user->title = $request->input('titleedit');
            $user->first_name = $request->input('first_name_edit');
            $user->last_name = $request->input('last_name_edit');
            $user->phone = $request->input('phoneedit');
            $user->email = $request->input('emailedit');
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Users updated successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update users',
            ], 500);
        }
    }

    public function updatechangePassword(Request $request)
    {
        $validateData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        if ($validateData) {
            $user = User::find($request->input('user_id'));

            if (!$user || !Hash::check($request->old_password, $user->password)) {
                return response()->json(['success' => false, 'message' => 'The old password does not match']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['success' => true, 'message' => 'Password updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update password']);
        }
    }
}
