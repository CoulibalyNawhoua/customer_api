<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\WarehouseRepository;
use App\Http\Resources\Api\WarehouseResource;
use App\Http\Resources\Api\SelectWarehouseResource;
use App\Http\Resources\Api\select\SelectShopResource;

class WarehouseController extends Controller
{
    private $warehouseRepository;

    public function __construct(WarehouseRepository $warehouseRepository)
    {
        $this->warehouseRepository=$warehouseRepository;
    }


    public function user_warehouse() {

        $resp = $this->warehouseRepository->user_warehouse();

        return new WarehouseResource($resp);
    }


    public function update_user_warehouse(Request $request){
         
        
        $validated = $request->validate([
            'warehouse_name' => 'required|string',
            'warehouse_email' => 'email|unique:warehouses,warehouse_email,'.Auth::user()->warehouse->id
        ]);

        $resp = $this->warehouseRepository->update_user_warehouse($request);

        return new WarehouseResource($resp);
    }


    public function warehouse_select() {
        
        $resp = $this->warehouseRepository->warehouse_select();

        return SelectWarehouseResource::collection($resp);

    }


    public function shop_select() {
        
        $resp = $this->warehouseRepository->shop_select();

        return SelectShopResource::collection($resp);
    }


    public function warehouse_zone($id)
    {
        $resp = $this->warehouseRepository->warehouse_zone($id);

        return response()->json(['data' => $resp]);
    }


    public function warehouse_list()  {
        
        
    }


    
}
