<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PaymentTypeResource;
use App\Repositories\PaymentTypeRepository;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{

    private $paymentTypeRepository;

    public function __construct(PaymentTypeRepository $paymentTypeRepository) {
        
        $this->paymentTypeRepository=$paymentTypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $resp = $this->paymentTypeRepository->getModelNotDelete();

         return PaymentTypeResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $resp = $this->paymentTypeRepository->create($request->all());

        return new PaymentTypeResource($resp);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resp = $this->paymentTypeRepository->view($id);

        return response()->json(['data'=>$resp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        
        $resp = $this->paymentTypeRepository->update($request->all(), $id);

        return new PaymentTypeResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->paymentTypeRepository->delete($id);

        return new PaymentTypeResource($resp);
    }
    

    public function updateStatusPayment($id)  {
        
        $resp = $this->paymentTypeRepository->updateStatusPayment($id);

        return new PaymentTypeResource($resp);
    }
}
