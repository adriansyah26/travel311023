<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        abort(404); // Menghasilkan "Not Found" jika product tidak ditemukan
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
            'code' => 'required|max:4|unique:products',
            'name' => 'required|unique:products',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan data ke database
            $product = Product::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Products created successfully',
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to created products'
            ], 500);
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
        abort(404); // Menghasilkan "Not Found" jika product tidak ditemukan
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        abort(404); // Menghasilkan "Not Found" jika product tidak ditemukan
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
        //
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

    public function editProduct($productId)
    {
        $product = Product::findOrFail($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }

    public function updateProduct(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'codeedit' => ['required', 'max:4', Rule::unique('products', 'code')->ignore($productId)],
            'nameedit' => ['required', Rule::unique('products', 'name')->ignore($productId)],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
            ], 400);
        }

        try {
            // Mencari Product berdasarkan ID
            $product = Product::findOrFail($productId);

            // Jika Product tidak ditemukan, kirim respons error
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            // Memperbarui data Product
            $product->code = $request->input('codeedit');
            $product->name = $request->input('nameedit');
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Products updated successfully',
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update products',
            ], 500);
        }
    }
}
