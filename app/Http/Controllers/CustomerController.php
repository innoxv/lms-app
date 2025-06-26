<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Customer::all());
    }

    public function store(Request $request): JsonResponse
    {
        $customer = Customer::create($request->all());
        return response()->json($customer, 201);
    }

    public function show(string $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return response()->json($customer);
    }

    public function destroy(string $id): JsonResponse
    {
        Customer::destroy($id);
        return response()->json(null, 204);
    }
}