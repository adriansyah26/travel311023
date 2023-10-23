<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductApiController extends Controller
{
    public function index()
    {
        try {
            $products = Product::latest()->get();

            return Api::json($products, 200, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve products', false);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:4|unique:products',
            'name' => 'required|unique:products',
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $products = Product::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
            ]);

            return Api::json($products, 201, 'Products created successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to create products', false);
        }
    }

    public function show($id)
    {
        try {
            $products = Product::find($id);

            if (!$products) {
                return Api::json([], 404, 'Products not found', false);
            }

            return Api::json($products, 200, 'Products retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve products', false);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'max:4', Rule::unique('products', 'code')->ignore($id)],
            'name' => ['required', Rule::unique('products', 'name')->ignore($id)],
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $products = Product::find($id);

            if (!$products) {
                return Api::json([], 404, 'Products not found', false);
            }

            $products->code = $request->input('code');
            $products->name = $request->input('name');
            $products->save();

            return Api::json($products, 200, 'Products updated successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to update Products', false);
        }
    }
}
