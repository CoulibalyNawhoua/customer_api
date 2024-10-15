<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Http\Resources\Api\OrderResource;
use App\Http\Resources\Api\mobile\WarehouseOrderResource;


class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository=$orderRepository;
    }

    public function order_list() {
        
        $resp = $this->orderRepository->orderList();

        return OrderResource::collection($resp);
    }

    public function order_warehouse()  {
        
        $resp = $this->orderRepository->order_warehouse();

        return WarehouseOrderResource::collection($resp);
    }

    public function store_order(Request $request){

        $resp = $this->orderRepository->store_order($request);

        return new WarehouseOrderResource($resp);
    }

    public function order_detail($id) {
        
        $resp = $this->orderRepository->order_detail($id);

        return response()->json(['data' => $resp]);
    }

    public function view_order($id) {
        
        $resp = $this->orderRepository->view_order($id);

        return response()->json(['data' => $resp]);
    }

    public function delete_order_items($id) {
        
        $resp = $this->orderRepository->deleteOrderItems($id);

        return response()->json(['message' => 'Le produit a été supprimer de la commande',], 200);
    }


    public function order_create()  {
        
        $resp = $this->orderRepository->order_create();

        return response()->json($resp);
    }

    public function update_order(Request $request, $id) {
        
        $resp = $this->orderRepository->update_order($request, $id);

        return new WarehouseOrderResource($resp);
    }

    public function delete_order($id) {
        
        $resp = $this->orderRepository->delete($id);

        return new OrderResource($resp);
    }


    public function accept_order(Request $request, $id) {
        
        $resp = $this->orderRepository->accept_order($request, $id);

        return response()->json($resp);
        /*return new OrderResource($resp);*/
    }

    public function cancel_order(Request $request, $id) {

        $validated = $request->validate([
            'comment' => 'required',
        ]);

        $resp = $this->orderRepository->cancel_order($request, $id);

        return response()->json($resp);

        /*return new OrderResource($resp);*/
    }

    public function mark_order_shipped($id)
    {
        $resp = $this->orderRepository->mark_order_shipped($id);

        return response()->json($resp);
    }


    public function order_history_received_warehouse()  {
        
        $resp = $this->orderRepository->order_history_received_warehouse();

        return response()->json(['data'=> $resp]);
    }

}
