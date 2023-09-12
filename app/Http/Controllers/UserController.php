<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        // Pastikan validasi berhasil sebelum membuat entri user
        if ($validateData) {
            User::create([
                'title' => $request->title,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make('admin123'), // Set password default di sini
            ]);

            return redirect()->route('user.index')
                ->with('success', 'Users created successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan user kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to create users')
                ->withInput();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
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
        $validateData = $request->validate([
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => ['required', "unique:users,email,$user->id,id"],
        ]);

        // Pastikan validasi berhasil sebelum mengupdate user
        if ($validateData) {

            $user->update([
                'title' => $request->title,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            return redirect()->route('user.index')
                ->with('success', 'User updated successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan pengguna kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to update user')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'Users deleted successfully');
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
