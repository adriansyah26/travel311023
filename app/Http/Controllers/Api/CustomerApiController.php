<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerApiController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::latest()->get();

            return Api::json($customers, 200, 'Customer retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve customer', false);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'termin' => 'required',
            'address' => 'required',
            'type_id' => 'required',
        ]);

        if (!empty($request->input('phone'))) {
            $validator->sometimes('phone', 'nullable', function ($input) {
                return !empty($input->phone);
            });
        }

        if (!empty($request->input('email'))) {
            $validator->sometimes('email', ['required', 'email', 'unique:customers,email'], function ($input) {
                return !empty($input->email);
            });
        }

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'termin' => $request->input('termin'),
                'address' => $request->input('address'),
                'type_id' => $request->input('type_id'),
            ]);

            return Api::json($customer, 201, 'Customer created successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to create customer', false);
        }
    }

    public function show($id)
    {
        try {
            $customer = Customer::find($id);

            if (!$customer) {
                return Api::json([], 404, 'Customer not found', false);
            }

            return Api::json($customer, 200, 'Customer retrieved successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to retrieve customer', false);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'termin' => 'required',
            'address' => 'required',
            'type_id' => 'required',
        ]);

        if (!empty($request->input('phone'))) {
            $validator->sometimes('phone', 'nullable', function ($input) {
                return !empty($input->phone);
            });
        }

        if (!empty($request->input('email'))) {
            $validator->sometimes('email', ['required', 'email', Rule::unique('customers', 'email')->ignore($id)], function ($input) {
                return !empty($input->email);
            });
        }

        if ($validator->fails()) {
            return Api::json([], 400, 'Validation error', false, ['errors' => $validator->errors()]);
        }

        try {
            $customer = Customer::find($id);

            if (!$customer) {
                return Api::json([], 404, 'Customer not found', false);
            }

            $customer->name = $request->input('name');
            $customer->phone = $request->input('phone');
            $customer->email = $request->input('email');
            $customer->termin = $request->input('termin');
            $customer->address = $request->input('address');
            $customer->type_id = $request->input('type_id');
            $customer->save();

            return Api::json($customer, 200, 'Customer updated successfully');
        } catch (\Exception $e) {
            return Api::json([], 500, 'Failed to update customer', false);
        }
    }
}
