<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\mobile\ProductSupplierResource;
use App\Repositories\ProductWarehouseRepository;
use App\Http\Resources\Api\mobile\ProductWarehouseResource;

class ProductWarehouseController extends Controller
{
    private $productWarehouseRepository;

    public function __construct(ProductWarehouseRepository $productWarehouseRepository)
    {
        $this->productWarehouseRepository=$productWarehouseRepository;
    }

    public function product_warehouse() {
        
        $resp = $this->productWarehouseRepository->productWarehouse();

        return ProductWarehouseResource::collection($resp);
        
    }


    public function supplier_product() {
        
        $resp = $this->productWarehouseRepository->supplierProduct();

        return ProductSupplierResource::collection($resp);
    }


    public function update_product_warehouse(Request $request) {
        
        $request->validate([
            'price' => 'numeric|min:0',
            'quantity' => 'numeric|min:0',
        ]);

        $resp = $this->productWarehouseRepository->update_product_warehouse($request);

        return new ProductWarehouseResource($resp);
    }

    
}
