<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Type;
use Illuminate\Http\Request;

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
        $types = Type::all();

        return view('customer.create', compact('types'));
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
            'name' => 'required',
            'phone' => 'required',
            'email' => ['required', 'email', 'unique:customers,email'],
            'termin' => 'required',
            'address' => 'required',
            'type_id' => 'required',
        ]);

        // Pastikan validasi berhasil sebelum membuat entri customer
        if ($validateData) {
            Customer::create($request->all());

            return redirect()->route('customer.index')
                ->with('success', 'Customers created successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan customer kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to create Customers')
                ->withInput();
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
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $types = Type::all();

        return view('customer.edit', compact('customer', 'types'));
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
        $validateData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => ['required', "unique:customers,email,$customer->id,id"],
            'termin' => 'required',
            'address' => 'required',
            'type_id' => 'required',
        ]);

        // Pastikan validasi berhasil sebelum melakukan pembaruan customer
        if ($validateData) {
            $customer->update($request->all());

            return redirect()->route('customer.index')
                ->with('success', 'Customers updated successfully');
        } else {
            // Jika validasi gagal, Anda dapat mengarahkan customer kembali ke halaman sebelumnya dengan pesan kesalahan.
            return redirect()->back()
                ->withErrors('Failed to update Customers')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Customer deleted successfully');
    }
}
