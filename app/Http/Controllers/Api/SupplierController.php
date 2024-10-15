<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SupplierRepository;
use App\Http\Resources\Api\SupplierResource;
use App\Http\Resources\Api\SelectSupplierResource;

class SupplierController extends Controller
{

    private $supplierRepository;
    
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }
    
    public function index()
    {
        $resp = $this->supplierRepository->supplierList();

        return SupplierResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            // 'email' => 'unique:suppliers'
        ]);

        $resp = $this->supplierRepository->storeSupplier($request);

        return new SupplierResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function viewSupplier(string $id) {
        
        $resp = $this->supplierRepository->view($id);

        return response()->json(['data'=>$resp]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            // 'email' => 'email'
        ]);

        $resp = $this->supplierRepository->updateSupplier($request,$id);

        return new SupplierResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->supplierRepository->delete($id);

        return new SupplierResource($resp);
    }


    public  function supplierSelect()  {
        
        $resp = $this->supplierRepository->supplierSelect();

        return SelectSupplierResource::collection($resp);
    }


    public function supplier_warehouse() {
        
        $resp = $this->supplierRepository->supplier_warehouse();

        return SelectSupplierResource::collection($resp);
    }


    public function supplier_select_warehouse() {
        
        $resp = $this->supplierRepository->supplierSelectWarehouse();

        return SelectSupplierResource::collection($resp);
    }
}
