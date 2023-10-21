<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        abort(404); // Menghasilkan "Not Found" jika type tidak ditemukan
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
            'code' => 'required|max:4|unique:types',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan data ke database
            $type = Type::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Type created successfully',
                'type' => $type,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to created type'
            ], 500);
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
        abort(404); // Menghasilkan "Not Found" jika type tidak ditemukan
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        abort(404); // Menghasilkan "Not Found" jika type tidak ditemukan
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        // 
    }

    public function editType($typeId)
    {
        $type = Type::findOrFail($typeId);

        if (!$type) {
            return response()->json([
                'success' => false,
                'message' => 'Type not found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'type' => $type,
        ]);
    }

    public function updateType(Request $request, $typeId)
    {
        $validator = Validator::make($request->all(), [
            'codeedit' => ['required', 'max:4', Rule::unique('types', 'code')->ignore($typeId)],
            'nameedit' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
            ], 400);
        }

        try {
            // Mencari Type berdasarkan ID
            $type = Type::findOrFail($typeId);

            // Jika Type tidak ditemukan, kirim respons error
            if (!$type) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type not found',
                ], 404);
            }

            // Memperbarui data Type
            $type->code = $request->input('codeedit');
            $type->name = $request->input('nameedit');
            $type->save();

            return response()->json([
                'success' => true,
                'message' => 'Type updated successfully',
                'type' => $type,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update type',
            ], 500);
        }
    }
}
