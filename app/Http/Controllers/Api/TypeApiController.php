<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TypeApiController extends Controller
{
    public function index()
    {
        try {
            $types = Type::latest()->get();

            return Api::json($types, 200, 'Type retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve type', false);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:4|unique:types',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $type = Type::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
            ]);

            return Api::json($type, 201, 'Type created successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to create type', false);
        }
    }

    public function show($id)
    {
        try {
            $type = Type::find($id);

            if (!$type) {
                return Api::json([], 404, 'Type not found', false);
            }

            return Api::json($type, 200, 'Type retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve type', false);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'max:4', Rule::unique('types', 'code')->ignore($id)],
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $type = Type::find($id);

            if (!$type) {
                return Api::json([], 404, 'Type not found', false);
            }

            $type->code = $request->input('code');
            $type->name = $request->input('name');
            $type->save();

            return Api::json($type, 200, 'Type updated successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to update type', false);
        }
    }
}
