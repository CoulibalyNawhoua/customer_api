<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\ProductQuantity;
use App\Models\PurchaseProduct;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class PurchaseRepository extends Repository
{
    public function __construct(Purchase $model)
    {
        $this->model = $model;
    }

    public function purchaseList () {
        

        $query = Purchase::selectRaw('purchases.add_date, purchases.reference, purchases.total_amount, suppliers.full_name AS supplier, purchases.uuid, purchases.id, purchases.expected_delivery_date, purchases.paid_amount,  purchases.due_amount, purchases.subtotal_amount')
                ->leftJoin('users', 'users.id', '=', 'purchases.added_by')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
                ->where('purchases.is_deleted', 0)
                ->get();

        return $query;

    }


    public function store_purchase(Request $request)  {
        

        $purchaseitem = $request->input('purchase_items');

        $purchasedata["supplier_id"] = $request->input("supplier_id");
        $purchasedata["purchase_date"] = $request->input("purchase_date");
        $purchasedata["delivery_date"] = $request->input("delivery_date");
        $purchasedata["expected_delivery_date"] = $request->input("expected_delivery_date");
        $purchasedata["number"] = $request->input("number");
        $purchasedata["discount_amount"] = $request->input("totaldiscount");
        $purchasedata["tax_amount"] = $request->input("totaltax");
        $purchasedata["subtotal_amount"] = $request->input("subtotal");
        $purchasedata["total_amount"] = $request->input("total");
        $purchasedata["reference"] = $this->genererCode('Purchase');
        $purchasedata["status"] = 0;
        $purchasedata["delivery_status"] = $request->input("delivery_status");
        $purchasedata["note"] = $request->input("note");
        $purchasedata["added_by"] = Auth::user()->id;
        $purchasedata["add_ip"] = $this->getIp();

        $purchase = Purchase::create($purchasedata);


        foreach (json_decode($purchaseitem) as $item) {
            
            $itemdata['product_id'] = $item->product_id;
            $itemdata['purchase_id'] = $purchase->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;

            PurchaseProduct::create($itemdata);

            
            if ($request->input("delivery_status") == 1) {
                $stock = ProductQuantity::where('product_id', $item['product_id'])
                    ->first();

                if (is_null($stock)) {
                    ProductQuantity::create([
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id'],
                    ]);
                }else{
                    $stock->increment('quantity', $item['quantity']);
                }

            }
            
        }


        return $purchase;
    }

    public function edit_purchase($id) {
        
        $invoice = Purchase::where('id', $id)->with(['purchase_items.product'])->first();

        return $invoice;
    }

    public function deletePurchaseItems($id) {
        return  PurchaseProduct::find($id)->delete();
    }

    public function  update_purchase(Request $request, $id) {
         
        $purchase = $this->model->find($id);


        $supplier_id = $request->supplier_id;
        $purchase_date = $request->purchase_date ;
        $delivery_date = $request->delivery_date ;
        $expected_delivery_date = $request->expected_delivery_date ;
        $number = $request->number ;
        $subtotal_amount = $request->subtotal ;
        $total_amount = $request->total ;
        $comment = $request->note;
        $totaldiscount = $request->totaldiscount ;
        $totaltax = $request->totaltax ;
        $edited_by = Auth::user()->id ;
        $edit_date = Carbon::now();
        $edit_ip = $this->getIp();


        if ($supplier_id == '' || $supplier_id == 'null' || $supplier_id == null) {

            $supplier_id = null;
        }

        if ($comment == '' || $comment == 'null' || $comment == null) {

            $comment = null;
        }


        $purchase->update([
            'supplier_id'=> $supplier_id,
            'purchase_date'=> $purchase_date,
            'delivery_date'=> $delivery_date,
            'expected_delivery_date'=> $expected_delivery_date,
            'number'=> $number,
            'discount_amount'=> $totaldiscount,
            'tax_amount'=> $totaltax,
            'subtotal_amount'=> $subtotal_amount,
            'total_amount'=> $total_amount,
            'note'=> $comment,
            'edited_by'=> $edited_by,
            'edit_date'=> $edit_date,
            'edit_ip' => $edit_ip
        ]);


        $purchaseitem = $request->input('purchase_items');

        $purchase->purchase_items()->delete();


        foreach (json_decode($purchaseitem) as $item) {
            
            $itemdata['product_id'] = $item->product_id;
            $itemdata['purchase_id'] = $purchase->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;
            $itemdata['product_tax'] = $item->product_tax;
            $itemdata['product_discount'] = $item->product_discount;
          
            PurchaseProduct::create($itemdata);

            if ($request->input("delivery_status") == 1) {
                $stock = ProductQuantity::where('product_id', $item['product_id'])
                    ->first();

                if (is_null($stock)) {
                    ProductQuantity::create([
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id'],
                    ]);
                }else{
                    $stock->increment('quantity', $item['quantity']);
                }

            }
        }



        return $purchase;

    }


    public function purchaseReport () {
        
        $query = Purchase::selectRaw('purchases.add_date, purchases.purchase_date, purchases.reference, purchases.total_amount, purchases.uuid, purchases.id, purchases.status, purchases.purchase_date, purchases.paid_amount, purchases.due_amount, suppliers.full_name AS supplier')
                ->leftJoin('users', 'users.id', '=', 'purchases.added_by')
                ->leftJoin('suppliers', 'suppliers.id','=','purchases.supplier_id')
                ->where('purchases.is_deleted', 0)
                ->get();
                
        return $query;

    }

    public function view_purchase($id) {
        
        $invoice = Purchase::where('id', $id)->with(['auteur', 'supplier', 'purchase_items.product'])->first();

        return $invoice;
    }

    public function create_purchase() {
        
        // $counter = Counter::where('code','purchase')->first();
        // $code_generer=random_int(000000,999999);
    
        // $invoice = Purchase::orderBy('id','DESC')->first();
    
        // if ($invoice) {
        //     $invoice=$invoice->id+1;
        //     $counters = $counter->value + $invoice;
        // } else {
        //     $counters = $counter->value;
        // }
    
    
        $formData = [
    
            'number' => '',
            'supplier_id' => '',
            'note' => '',
            'reference' => '',
            'tax_percentage' => 0,
            'discount_percentage' => 0,
            'due_date' => '',
            'delivery_date' => Carbon::now()->format('Y-m-d'),
            'purchase_date' => Carbon::now()->format('Y-m-d'),
            'expected_delivery_date' => Carbon::now()->format('Y-m-d'),
            'tax_amount' => 0,
            'shipping_amount' => 0,
            'status' => 0,
            'delivery_status' => 0,
            'items' => [
                'product_id' => '',
                'product' => '',
                'unit_price' => 0,
                'quantity' => 1,
                'product_discount_percentage' => 0,
                'product_tax_percentage' => 0
    
            ]
    
        ];
    
        return $formData;
        
        }
    


}
