<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SaleRepository;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Resources\Api\SaleResource;

class SaleController extends Controller
{

    protected $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }
    
    public function sale_list() {
        
        $resp = $this->saleRepository->saleList();

        // return SaleResource::collection($resp);

        return response()->json(['data' => $resp]);
    }


    public function warehouse_sales() {
        
        $resp = $this->saleRepository->warehouse_sales();

        return response()->json(['data'=>$resp]);
    }


    public function store_sale(Request $request){

        $resp = $this->saleRepository->store_sale($request);

        // return new SaleResource($resp);
        return response()->json(['resp' => $resp]);

    }


    // public function view_sale($id) {
        
    //     $resp = $this->saleRepository->view_sale($id);

    //     return response()->json(['data' => $resp]);
    // }


    public function delete_sale($id) {
        
        $resp = $this->saleRepository->delete($id);

        return new SaleResource($resp);
    }

    public function invoiceReport() {
        
        $resp = $this->saleRepository->invoiceReport();

        return SaleResource::collection($resp);
    }


    public function count_warehouse_sales() {
        
        $resp = $this->saleRepository->count_warehouse_sales();

        return response()->json(['data' => $resp]);
    }


    public function warehouse_sale_product($reference) {
        
        $resp = $this->saleRepository->warehouse_sale_product($reference);

        return response()->json(['data'=>$resp]);
    }

    public function sum_warehouse_week_sales() {
        
        $resp = $this->saleRepository->sum_warehouse_week_sales();

        return response()->json(['data'=>$resp]);
    }

    public function sum_warehouse_week_sales_detail($date) {
        
        $resp = $this->saleRepository->sum_warehouse_week_sales_detail($date);

        return response()->json(['data'=>$resp]);
    }

}
