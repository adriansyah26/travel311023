<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Type::latest()->get();

        return view('master-data.type.index', compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.type.create');
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
            'code' => 'required|max:4',
            'name' => 'required',
        ]);

        // Pastikan validasi berhasil sebelum membuat entri type
        if ($validateData) {
            Type::create($request->all());

            return redirect()->route('type.index')
                ->with('success', 'Type created successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan type kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to create type')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('master-data.type.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $validateData = $request->validate([
            'code' => 'required|max:4',
            'name' => 'required',
        ]);

        // Pastikan validasi berhasil sebelum melakukan pembaruan type
        if ($validateData) {
            $type->update($request->all());

            return redirect()->route('type.index')
                ->with('success', 'Type updated successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan type kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to update type')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return redirect()->route('type.index')
            ->with('success', 'Type deleted successfully');
    }
}
