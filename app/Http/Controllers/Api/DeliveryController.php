<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\DeliveryResource;
use App\Repositories\DeliveryRepository;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    protected $deliveryRepository;

    public function __construct(DeliveryRepository $deliveryRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
    }


    public function store_delivery(Request $request) {
        
        $resp = $this->deliveryRepository->store_delivery($request);

        return response()->json(['data' => 'success']);
    }

    public function delivery_list() {
        
        $resp = $this->deliveryRepository->delivery_list();

        return DeliveryResource::collection($resp);
    }

    public function view_delivery($uuid) {
        
        $resp  = $this->deliveryRepository->view_delivery($uuid);

        return response()->json(['data' => $resp]);
    }


    public function delete_delivery($id) {
        
        $resp = $this->deliveryRepository->delete($id);

        return new DeliveryResource($resp);
    }


    //consultation livraison pour un livreur
    public function consult_delivery() {
        
        $resp = $this->deliveryRepository->consult_delivery();

        return  DeliveryResource::collection($resp);
    }


    public function mark_delivered($id) {
        
        $resp = $this->deliveryRepository->mark_delivered($id);

        return new DeliveryResource($resp);
    }

    public function send_delivered($id) {
        
        $resp = $this->deliveryRepository->send_delivered($id);

        return new DeliveryResource($resp);
    }

    public function cancel_delivered($id) {
        
        $resp = $this->deliveryRepository->cancel_delivered($id);

        return new DeliveryResource($resp);
    }


    
    

    

    
}
