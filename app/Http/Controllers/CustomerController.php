<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::latest()->get();
        $types = Type::all();

        return view('customer.index', compact('customer', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404); // Menghasilkan "Not Found" jika customer tidak ditemukan
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
            'name' => 'required',
            'termin' => 'required',
            'address' => 'required',
            'type_id' => 'required',
        ]);

        // Cek apakah 'phone' tidak kosong, jika tidak kosong maka validasi akan diterapkan
        if (!empty($request->input('phone'))) {
            $validator->sometimes('phone', 'nullable', function ($input) {
                return !empty($input->phone);
            });
        }

        // Cek apakah 'email' tidak kosong, jika tidak kosong maka validasi akan diterapkan
        if (!empty($request->input('email'))) {
            $validator->sometimes('email', ['required', 'email', 'unique:customers,email'], function ($input) {
                return !empty($input->email);
            });
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan data ke database
            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'termin' => $request->input('termin'),
                'address' => $request->input('address'),
                'type_id' => $request->input('type_id'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Customers created successfully',
                'customer' => $customer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to created customers'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        abort(404); // Menghasilkan "Not Found" jika customer tidak ditemukan
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        abort(404); // Menghasilkan "Not Found" jika customer tidak ditemukan
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        // 
    }

    public function editCustomer($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'customer' => $customer,
        ]);
    }

    public function updateCustomer(Request $request, $customerId)
    {
        $validator = Validator::make($request->all(), [
            'nameedit' => 'required',
            'terminedit' => 'required',
            'addressedit' => 'required',
            'type_id_edit' => 'required',
        ]);

        // Cek apakah 'phoneedit' tidak kosong, jika tidak kosong maka validasi akan diterapkan
        if (!empty($request->input('phoneedit'))) {
            $validator->sometimes('phoneedit', 'nullable', function ($input) {
                return !empty($input->phoneedit);
            });
        }

        // Cek apakah 'emailedit' tidak kosong, jika tidak kosong maka validasi akan diterapkan
        if (!empty($request->input('emailedit'))) {
            $validator->sometimes('emailedit', ['required', 'email', Rule::unique('customers', 'email')->ignore($customerId)], function ($input) {
                return !empty($input->emailedit);
            });
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
            ], 400);
        }

        try {
            // Mencari Customer berdasarkan ID
            $customer = Customer::findOrFail($customerId);

            // Jika customer tidak ditemukan, kirim respons error
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found',
                ], 404);
            }

            // Memperbarui data customer
            $customer->name = $request->input('nameedit');
            $customer->phone = $request->input('phoneedit');
            $customer->email = $request->input('emailedit');
            $customer->termin = $request->input('terminedit');
            $customer->address = $request->input('addressedit');
            $customer->type_id = $request->input('type_id_edit');
            $customer->save();

            return response()->json([
                'success' => true,
                'message' => 'Customers updated successfully',
                'customer' => $customer,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update customers',
            ], 500);
        }
    }
}
