<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::latest()->get();

        return view('master-data.product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.product.create');
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

        // Pastikan validasi berhasil sebelum membuat entri product
        if ($validateData) {
            Product::create($request->all());

            return redirect()->route('product.index')
                ->with('success', 'Product created successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan product kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to create product')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('master-data.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validateData = $request->validate([
            'code' => 'required|max:4',
            'name' => 'required',
        ]);

        // Pastikan validasi berhasil sebelum melakukan pembaruan product
        if ($validateData) {
            $product->update($request->all());

            return redirect()->route('product.index')
                ->with('success', 'Product updated successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan product kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to update product')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')
            ->with('success', 'Product deleted successfully');
    }
}
