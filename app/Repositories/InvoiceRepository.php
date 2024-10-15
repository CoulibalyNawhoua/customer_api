<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Counter;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\PurchaseProduct;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class InvoiceRepository extends Repository
{
    public function __construct(Purchase $model)
    {
        $this->model = $model;
    }

    public function create_invoice() {

        $code_generer=random_int(000000,999999);

        $formData = [
            'number' => '',
            'warehouse_id' => '',
            'delivery_address' => '',
            'reference' => '',
            'delivery_date' => Carbon::now()->format('Y-m-d'),
            'order_date' => Carbon::now()->format('Y-m-d'),
            'expected_delivery_date' => Carbon::now()->format('Y-m-d'),
            'shipping_amount' => 0,
            'discount_amount' => 0,
            'delivery_option' => null,
            'delivery_with_invoice' => 0,
            'be_delivered' => 0,
            'status' => 2,
            'items' => [
                'product_id' => '',
                'product' => '',
                'unit_price' => 0,
                'quantity' => 1,
                'product_discount' => 0,
                'product_tax' => 0
            ]
    
        ];
    
        return $formData;
    }

    public function store_invoice(Request $request)  {
        
        $invoiceitem = $request->input('order_items');


        if ($request->input("number") == '' || $request->input("number") == 'null' || $request->input("number") == null) {

            $number = null;
        }else{
            $number = $request->input("number");
        }

        if ($request->input("delivery_address") == '' || $request->input("delivery_address") == 'null' || $request->input("delivery_address") == null) {

            $delivery_address = null;
        }else{
            $delivery_address = $request->input("delivery_address");
        }

        $invoicedata["warehouse_id"] = $request->input("warehouse_id");
        $invoicedata["order_date"] = $request->input("order_date");
        $invoicedata["expected_delivery_date"] = $request->input("expected_delivery_date");
        $invoicedata["number"] = $number;
        $invoicedata["discount_amount"] = $request->input("totaldiscount");
        $invoicedata["tax_amount"] = $request->input("totaltax");
        $invoicedata["subtotal_amount"] = $request->input("subtotal");
        $invoicedata["total_amount"] = $request->input("total");
        $invoicedata["reference"] = $this->genererCode('Order');
        $invoicedata["status"] = 2;
        $invoicedata['shipping_amount'] = $request->input('shipping_amount');
        $invoicedata["delivery_address"] = $request->input("be_delivered") == 1 ? $delivery_address : '';
        $invoicedata["be_delivered"] = $request->input("be_delivered");
        $invoicedata["delivery_with_invoice"] = $request->input("delivery_with_invoice");
        $invoicedata["added_by"] = Auth::user()->id;
        $invoicedata["add_ip"] = $this->getIp();

        $invoice = Order::create($invoicedata);




        foreach (json_decode($invoiceitem) as $item) {
            
            $itemdata['product_id'] = $item->id;
            $itemdata['order_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;

            OrderProduct::create($itemdata);
        }

        return $invoice;

    }

    public function view_invoice($id) {
        
        $invoice = Order::where('id', $id)->with(['warehouse','order_items.product'])->first();

        return $invoice;
    }


    public function deleteInvoiceItems($id) {

        return  OrderProduct::find($id)->delete();
    }

    public function  update_invoice(Request $request, $id) {
        
        $invoice = $this->model->find($id);

        if ($request->input("number") == '' || $request->input("number") == 'null' || $request->input("number") == null) {

            $number = null;
        }else{
            $number = $request->input("number");
        }

        if ($request->input("delivery_address") == '' || $request->input("delivery_address") == 'null' || $request->input("delivery_address") == null) {

            $delivery_address = null;
        }else{
            $delivery_address = $request->input("delivery_address");
        }

        $warehouse_id = $request->warehouse_id;
        $order_date = $request->order_date ;
        $expected_delivery_date = $request->expected_delivery_date ;
        $discount_amount = $request->totaldiscount ;
        $tax_amount = $request->tax_amount ;
        $subtotal_amount = $request->subtotal ;
        $total_amount = $request->total ;
        $edited_by = Auth::user()->id ;
        $edit_date = Carbon::now();
        $edit_ip = $this->getIp();

        $invoice->update([
            'warehouse_id'=> $warehouse_id,
            'order_date'=> $order_date,
            'expected_delivery_date'=> $expected_delivery_date,
            'number'=> $number,
            'discount_amount'=> $discount_amount,
            'tax_amount' => $tax_amount,
            'subtotal_amount'=> $subtotal_amount,
            'total_amount'=> $total_amount,
            'status'=> 2,
            'delivery_address' => $request->input("be_delivered") == 1 ? $delivery_address : '',
            'be_delivered' => $request->input("be_delivered"),
            'delivery_with_invoice' => $request->input("delivery_with_invoice"),
            'edited_by'=> $edited_by,
            'edit_date'=> $edit_date,
            'edit_ip' => $edit_ip
        ]);


        $invoiceitem = $request->input('order_items');

        $invoice->invoice_items()->delete();


        foreach (json_decode($invoiceitem) as $item) {
            
            $itemdata['product_id'] = $item->product_id;
            $itemdata['purchase_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;

            PurchaseProduct::create($itemdata);
        }

        return $invoice;

    }

    
}
