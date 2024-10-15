<?php

namespace App\Repositories;

use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Models\DeliveryProduct;
use App\Models\Order;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class DeliveryRepository extends Repository
{
   
    public function __construct(Delivery $model)
    {
        $this->model=$model;
    }

    public function store_delivery(Request $request)  {
        
        $invoiceitem = $request->input('order_items');

        $order = Order::where('id', $request->order_id)->first();

        $invoicedata["expected_delivery_date"] = $request->input("expected_delivery_date");
        $purchasedata["discount_amount"] = $request->input("totaldiscount");
        $purchasedata["tax_amount"] = $request->input("totaltax");
        $invoicedata["subtotal_amount"] = $request->input("subtotal");
        $invoicedata["total_amount"] = $request->input("total");
        $invoicedata["reference"] = $this->genererCode('Delivery');
        $invoicedata["note"] = $request->input("note");
        $invoicedata["added_by"] = Auth::user()->id;
        $invoicedata["add_ip"] = $this->getIp();
        $invoicedata['shipping_amount'] = $request->input('shipping_amount');
        $invoicedata["order_id"] = $order->id;
        $invoicedata["warehouse_id"] = $order->warehouse_id;
        $invoicedata["status"] = $request->input('status');
        $invoicedata["delivery_person_id"] = $request->input('delivery_person_id');

        $delivery = Delivery::create($invoicedata);


        foreach (json_decode($invoiceitem) as $item) {
            
            $itemdata['product_id'] = $item->product_id;
            $itemdata['delivery_id'] = $delivery->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;

            DeliveryProduct::create($itemdata);

        }

        return $delivery;

    }


    public function delivery_list() {
        
        $query = Delivery::leftJoin('users', 'users.id', '=', 'deliveries.added_by')
                    ->leftJoin('orders', 'orders.id', '=', 'deliveries.order_id')
                    ->leftJoin('warehouses', 'warehouses.id', '=', 'orders.warehouse_id')
                    ->leftJoin('users AS delivery_person', 'delivery_person.id', '=', 'deliveries.delivery_person_id')
                    ->where('deliveries.is_deleted', 0);
                    

        return $query->selectRaw('deliveries.add_date, deliveries.reference AS delivery_reference, deliveries.total_amount, warehouses.warehouse_name, deliveries.uuid, deliveries.id, deliveries.expected_delivery_date, deliveries.discount_amount,  deliveries.shipping_amount, orders.reference AS order_reference, delivery_person.full_name AS delivery_person, deliveries.status')->get();

    }


    public function view_delivery($uuid) {
        
        $order = Delivery::where('uuid', $uuid)->with(['order.auteur', 'warehouse', 'deliveries_items.product'])->firstOrFail();

        return $order;
    }


    public function consult_delivery() {
        
        $user = Auth::user();

        $query = Delivery::leftJoin('users', 'users.id', '=', 'deliveries.added_by')
            ->leftJoin('orders', 'orders.id', '=', 'deliveries.order_id')
            ->leftJoin('warehouses', 'warehouses.id', '=', 'orders.warehouse_id')
            ->where('deliveries.delivery_person_id', $user->id)
            ->whereIn('deliveries.status', [1, 2, 3])
            ->where('deliveries.is_deleted', 0);
        

        return $query->selectRaw('deliveries.add_date, deliveries.reference AS delivery_reference, deliveries.total_amount, warehouses.warehouse_name, deliveries.uuid, deliveries.id, deliveries.expected_delivery_date, deliveries.discount_amount,  deliveries.shipping_amount, orders.reference AS order_reference, deliveries.status')->get();
    }


    public function mark_delivered($id) {

        $delivery = $this->model->find($id);

        $delivery->update([
            'status' => 2
        ]);

        return $delivery;
    }


    public function send_delivered($id) {

        $delivery = $this->model->find($id);

        $delivery->update([
            'status' => 1
        ]);

        return $delivery;
    }

    public function cancel_delivered($id) {

        $delivery = $this->model->find($id);

        $delivery->update([
            'status' => 3
        ]);

        return $delivery;
    }

    
}
