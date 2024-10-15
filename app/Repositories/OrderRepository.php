<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Counter;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\ProductWarehouse;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;


class OrderRepository extends Repository
{
    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function orderList () {
        

        $query = Order::selectRaw('orders.add_date, orders.reference, orders.total_amount, warehouses.warehouse_name, orders.uuid, orders.id, orders.expected_delivery_date, orders.paid_amount,  orders.due_amount, orders.status, orders.order_date, orders.subtotal_amount,  orders.shipping_amount, users.full_name AS auteur, users.type_user, orders.process_status')
                ->leftJoin('users', 'users.id', '=', 'orders.added_by')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'orders.warehouse_id')
                ->where('orders.is_deleted', 0)
              /*  ->where('orders.status', '>=', 1)*/
                ->orderBy('orders.created_at', 'desc')
                ->get();
        return $query;

    }


    public function order_warehouse () {
        
        $warehouse_id = (Auth::user()->warehouse) ? Auth::user()->warehouse->id : NULL ;

        $query = Order::selectRaw('orders.add_date, orders.reference, orders.total_amount, orders.id, orders.status, orders.shipping_amount, orders.subtotal_amount, orders.comment')
                ->leftJoin('users', 'users.id', '=', 'orders.added_by')
                ->where('orders.warehouse_id', $warehouse_id)
                // ->where('orders.added_by', Auth::user()->id)
                ->where('orders.is_deleted', 0)
                ->orderBy('orders.add_date', 'desc')
                ->get();

        return $query;

    }

    public function store_order(Request $request)  {
        
        $warehouse_id = (Auth::user()->warehouse) ? Auth::user()->warehouse->id : NULL ;

        $order_items = $request->json()->all();

        $order = Order::create([
            'warehouse_id' => $warehouse_id,
            'reference'=>$this->genererCode('Order'),
            'total_amount' => $order_items['total_amount'],
            'shipping_amount' => $order_items['shipping_amount'],
            'subtotal_amount' => $order_items['subtotal_amount'],
            'status' => 1,
            'be_delivered' => $order_items['be_delivered'],
            'delivery_with_invoice' => $order_items['delivery_with_invoice'],
            'order_date' => Carbon::now(),
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp()
        ]);

        foreach ($order_items['order_items'] as $item) {

            $itemdata['product_id'] = $item['product_id'];
            $itemdata['order_id'] = $order->id;
            $itemdata['quantity'] = $item['quantity'];
            $itemdata['unit_price'] = $item['price'];

            OrderProduct::create($itemdata);
        }
        return  $order;
    }

    public function order_detail($id) {
        
        $order = Order::where('id', $id)->with(['auteur', 'warehouse.assigned_user' ,'order_items.product.unit'])->first();

        return $order;
    }

    public function deleteOrderItems($id) {
        return  OrderProduct::find($id)->delete();
    }

    public function  update_order(Request $request, $id) {
        
        $order = $this->model->find($id);

        $order_items = $request->json()->all();

        $order->update([
            'total_amount' => $order_items['total_amount'],
            'shipping_amount' => $order_items['shipping_amount'],
            'subtotal_amount' => $order_items['subtotal_amount'],
            'status' => $order_items['status'],
            'be_delivered' => $order_items['be_delivered'],
            'delivery_with_invoice' => $order_items['delivery_with_invoice'],
            'edited_by'=> Auth::user()->id,
            'edit_date'=> Carbon::now(),
            'edit_ip' => $this->getIp()
        ]);

        $order->order_items()->delete();

        foreach ($order_items['order_items'] as $item) {
            
            $itemdata['product_id'] = $item['product_id'];
            $itemdata['order_id'] = $order->id;
            $itemdata['quantity'] = $item['quantity'];
            $itemdata['unit_price'] = $item['price'];
            
            OrderProduct::create($itemdata);
        }
        return $order;

    }


    public function orderReport () {
        
        $query = Order::selectRaw('orders.add_date, orders.purchase_date, orders.reference, orders.total_amount, warehouses.warehouse_name, orders.uuid, orders.id, orders.status, orders.purchase_date, orders.paid_amount, orders.due_amount, suppliers.full_name AS supplier')
                ->leftJoin('users', 'users.id', '=', 'orders.added_by')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'orders.warehouse_id')
                ->leftJoin('suppliers', 'suppliers.id','=','orders.supplier_id')
                ->where('orders.is_deleted', 0)
                ->get();
                

        return $query;

    }


    public function store_order_receipt(Request $request) {
        
        $warehouse_id = (Auth::user()->warehouse) ? Auth::user()->warehouse->id : NULL ;

        $productStck = ProductWarehouse::where('warehouse_id', $warehouse_id)
                                    ->where('product_id', $request->id)
                                    ->first();

        if (is_null($productStck)) {

        }
        {
            $productStck->increment('quantity', $request->quantity);
        }

        return $productStck;
       
    }

    public function view_order($id) {
        
        $order = Order::where('id', $id)->selectRaw('add_date, reference, total_amount, id, status, shipping_amount, subtotal_amount, comment')->first();

        $orderitems = OrderProduct::selectRaw('orders_products.product_id, orders_products.unit_price, orders_products.quantity, orders_products.id, products.designation, products.image_url')
                            ->leftJoin('products', 'products.id', '=', 'orders_products.product_id')
                            ->where('orders_products.order_id', $id)
                            ->get();

        $data = [
            'order' => $order,
            'orderitems' => $orderitems
        ];

        return $data;
    }


    public function accept_order(Request $request, $id)  {
        
        $order = $this->model->find($id);

        $order->update([
            'status'=> 2,
            'process_status'=> 1,
            'comment' => $request->comment
        ]);

        return $order;
    }


    public function cancel_order(Request $request, $id)  {
        
        $order = $this->model->find($id);

        $order->update([
            'status'=> 0,
            'process_status'=> 3,
            'comment' => $request->comment
        ]);

        return $order;
    }

/*    public function order_process_close($id)  {

        $order = $this->model->find($id);

        $order->update([
            'process_status'=> 2,
        ]);

        return $order;
    }*/

    public function order_create() {
    

        $formData = [
            'number' => '',
            'warehouse_id' => '',
            'note' => '',
            'reference' => '',
            'delivery_date' => Carbon::now()->format('Y-m-d'),
            'order_date' => Carbon::now()->format('Y-m-d'),
            'expected_delivery_date' => Carbon::now()->format('Y-m-d'),
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'status' => 2,
            'items' => [
                'product_id' => '',
                'product' => '',
                'unit_price' => 0,
                'quantity' => 1,
            ]
    
        ];
    
        return $formData;
    }

    public function mark_order_shipped($id)
    {
        $order = $this->model->find($id);

        $order->update([
            'status'=> 4,
        ]);
        return $order;
    }


    public function order_history_received_warehouse () {
        
        $warehouse_id = Auth::user()->warehouse;

        $query = Order::selectRaw('orders.add_date, orders.reference, orders.total_amount, orders.id, orders.status, orders.shipping_amount, orders.subtotal_amount, orders.uuid')
                ->leftJoin('users', 'users.id', '=', 'orders.added_by')
                ->where('orders.warehouse_id', $warehouse_id)
                ->where('orders.added_by', Auth::user()->id)
                ->where('orders.status', 3)
                ->orderBy('orders.add_date', 'desc')
                ->get();

        return $query;

    }
}