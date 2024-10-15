<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepository;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Http\Resources\Api\SelectCustomerResource;

class CustomerController extends Controller
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $resp = $this->customerRepository->customerList();

        return CustomerResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $resp = $this->customerRepository->storeCustomer($request);

        return new CustomerResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function viewCustomer(string $id)
    {
        $resp = $this->customerRepository->edit($id);

        return response()->json(['data' => $resp]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'full_name' => 'required',
            'email' => 'email'
        ]);
        
        $resp = $this->customerRepository->updateCustomer($request, $id);

        return new CustomerResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->customerRepository->delete($id);

        return new CustomerResource($resp);
    }

    public function customer_select() {
        
        $resp = $this->customerRepository->customer_select();

        return SelectCustomerResource::collection($resp);
    }
}
