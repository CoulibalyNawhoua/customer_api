<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PurchaseRepository;
use App\Http\Resources\Api\PurchaseResource;
use App\Http\Resources\Api\mobile\PurchaseWarehouseResource;

class PurchaseController extends Controller
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function index()
    {
        $resp = $this->purchaseRepository->purchaseList();

        return PurchaseResource::collection($resp);
    }


    public function store(Request $request){

        $resp = $this->purchaseRepository->store_purchase($request);

        return response()->json(['message'=>'success']);;
    }


    public function edit_purchase($id) {
        
        $resp = $this->purchaseRepository->edit_purchase($id);

        return response()->json(['data' => $resp]);
    }

    public function delete_purchase_items($id) {
        
        $resp = $this->purchaseRepository->deletePurchaseItems($id);

        return response()->json(['message' => 'Le produit a été supprimer de la commande',], 200);
    }


    public function update_purchase(Request $request, $id) {
        
        $resp = $this->purchaseRepository->update_purchase($request, $id);

        return new PurchaseResource($resp);
    }

    public function view_purchase($id)  {
        
        $resp = $this->purchaseRepository->view_purchase($id);

        return response()->json(['data' => $resp]);
    }


    public function create_purchase() {
        
        $resp = $this->purchaseRepository->create_purchase();

        return response()->json($resp);
    }


    public function destroy(string $id)
    {
        $resp = $this->purchaseRepository->delete($id);

        return new PurchaseResource($resp);
    }


    public function add_purchase_receipt($id) {
        
        $resp = $this->purchaseRepository->view_purchase($id);

        return response()->json(['data' => $resp]);
    }

}
