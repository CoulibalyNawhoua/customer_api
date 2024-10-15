<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Quotation;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\QuotationProduct;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class QuotationRepository extends Repository
{
    public function __construct(Quotation $model)
    {
        $this->model = $model;
    }


    public function create_quotation() {
        
        // $code_generer=random_int(000000,999999);

        $formData = [
            'number' => '',
            'warehouse_id' => '',
            'note' => '',
            'reference' => '',
            'validate_date' => Carbon::now()->format('Y-m-d'),
            'quotation_date' => Carbon::now()->format('Y-m-d'),
            'discount_amount' => 0,
            'status' => 0,
            'items' => [
                'product_id' => '',
                'product' => '',
                'unit_price' => 0,
                'quantity' => 1,
                'product_tax' => 0,
                'product_discount' => 0
            ]
    
        ];
    
        return $formData;
    }


    public function store_quotation(Request $request)  {
        
        $items = $request->input('quotation_items');


        if ($request->input("number") == '' || $request->input("number") == 'null' || $request->input("number") == null) {

            $number = null;
        }

        $invoicedata["warehouse_id"] = $request->input("warehouse_id");
        $invoicedata["quotation_date"] = $request->input("quotation_date");
        $invoicedata["validate_date"] = $request->input("validate_date");
        $invoicedata["number"] = $number;
        $purchasedata["discount_amount"] = $request->input("totaldiscount");
        $purchasedata["tax_amount"] = $request->input("totaltax");
        $invoicedata["subtotal_amount"] = $request->input("subtotal");
        $invoicedata["total_amount"] = $request->input("total");
        $invoicedata["reference"] = $this->genererCode('Quotation');
        $invoicedata["added_by"] = Auth::user()->id;
        $invoicedata["add_ip"] = $this->getIp();

        $quotation = Quotation::create($invoicedata);


        foreach (json_decode($items) as $item) {
            
            $itemdata['product_id'] = $item->id;
            $itemdata['quotation_id'] = $quotation->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;

            QuotationProduct::create($itemdata);
        }

        return $quotation;

    }

    public function quotationList () {
        

        $query = Quotation::selectRaw('quotations.add_date, quotations.reference, quotations.total_amount, warehouses.warehouse_name, quotations.uuid, quotations.id, quotations.status, quotations.quotation_date, quotations.subtotal_amount, quotations.tax_amount, quotations.discount_amount')
                ->leftJoin('users', 'users.id', '=', 'quotations.added_by')
                ->leftJoin('warehouses', 'warehouses.id', '=', 'quotations.warehouse_id')
                ->where('quotations.is_deleted', 0)
                ->get();

        return $query;

    }


    public function show_quotation($id) {
        
        $query = Quotation::where('id', $id)->with(['quotation_items.product','warehouse'])->first();

        return $query;
    }


    public function deleteQuotationItems($id)  {
        
        return  QuotationProduct::find($id)->delete();
    }

    public function update_quotation(Request $request, $id) {
        
        $quotation = $this->model->find($id);
    
    
        $warehouse_id = $request->warehouse_id;
        $quotation_date = $request->quotation_date ;
        $validate_date = $request->validate_date ;
        $number = $request->number ;
        $subtotal_amount = $request->subtotal ;
        $total_amount = $request->total ;
        $totaldiscount = $request->totaldiscount;
        $totaltax = $request->totaltax;
        $edited_by = Auth::user()->id ;
        $edit_date = Carbon::now();
        $edit_ip = $this->getIp();

        if ($number == '' || $number == 'null' || $number == null) {

            $numberNum = null;
        }


        $quotation->update([
            'warehouse_id'=> $warehouse_id,
            'quotation_date'=> $quotation_date,
            'validate_date'=> $validate_date,
            'number'=> $numberNum,
            'subtotal_amount'=> $subtotal_amount,
            'total_amount'=> $total_amount,
            'discount_amount'=> $totaldiscount,
            'tax_amount'=> $totaltax,
            'edited_by'=> $edited_by,
            'edit_date'=> $edit_date,
            'edit_ip' => $edit_ip
        ]);


        $items = $request->input('quotation_items');

        $quotation->quotation_items()->delete();


        foreach (json_decode($items) as $item) {
            
            $itemdata['product_id'] = $item->product_id;
            $itemdata['quotation_id'] = $quotation->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;

            QuotationProduct::create($itemdata);
        }

        return $quotation;

    }

    public function accept_quotation($id) {
        
        $quotation = $this->model->find($id);


        $items = QuotationProduct::where('quotation_id', $quotation->id)->get();

        $quotation->update([
            'status' => 1
        ]);


        $orderdata["warehouse_id"] = $quotation->warehouse_id;
        $orderdata["order_date"] = Carbon::now();
        $orderdata["expected_delivery_date"] =  Carbon::now();
        $orderdata["discount_amount"] = $quotation->discount_amount;
        $orderdata["tax_amount"] = $quotation->tax_amount;
        $orderdata["subtotal_amount"] = $quotation->subtotal_amount;
        $orderdata["total_amount"] = $quotation->total_amount;
        $orderdata["reference"] = $this->genererCode('Order');
        $orderdata["status"] = 2;
        $orderdata["added_by"] = Auth::user()->id;
        $orderdata["add_ip"] = $this->getIp();

        $order = Order::create($orderdata);


        foreach ($items as $item) {
            
            $itemdata['product_id'] = $item->product_id;
            $itemdata['order_id'] = $order->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;
            
            OrderProduct::create($itemdata);
        }

    }

    public function refund_quotation($id) {
        
        $quotation = $this->model->find($id);

        $quotation->update([
            'status' => 2
        ]);

    }
}
