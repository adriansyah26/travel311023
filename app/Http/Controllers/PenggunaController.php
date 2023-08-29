<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengguna = Pengguna::latest()->get();

        return view('pengguna.index', compact('pengguna'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengguna.create');
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
            'email' => ['required', 'email', 'unique:penggunas,email'],
        ]);

        // Pastikan validasi berhasil sebelum membuat entri pengguna
        if ($validateData) {
            Pengguna::create($request->all());

            return redirect()->route('pengguna.index')
                ->with('success', 'Users created successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan pengguna kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to create users')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function show(Pengguna $pengguna)
    {
        return view('pengguna.show', compact('pengguna'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengguna $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => ['required', "unique:penggunas,email,$pengguna->id,id"],
        ]);

        // Pastikan validasi berhasil sebelum melakukan pembaruan pengguna
        if ($validateData) {
            $pengguna->update($request->all());

            return redirect()->route('pengguna.index')
                ->with('success', 'Users updated successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan pengguna kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to update users')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengguna  $pengguna
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();

        return redirect()->route('pengguna.index')
            ->with('success', 'Users deleted successfully');
    }
}
