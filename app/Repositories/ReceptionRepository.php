<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductWarehouse;
use App\Models\Reception;
use App\Models\ReceptionProduct;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class ReceptionRepository extends Repository
{
    public function __construct(Reception $model)
    {
        $this->model=$model;
    }

    public function store_receipt_order(Request $request)  {
        
        $warehouse_id = (Auth::user()->warehouse) ? Auth::user()->warehouse->id : NULL ;

        $data = $request->json()->all();



        $reception = Reception::create([
            'reference' => $this->genererCode('Reception'),
            'total_amount' => $data['total_amount'],
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp(),
            'warehouse_id' => $warehouse_id,
            'order_id' => $data['order_id']
        ]);

        foreach ($data['order_items'] as $item) {

            if ($item['isEnabled'] == true){
                $itemdata['product_id'] = $item['product_id'];
                $itemdata['reception_id'] = $reception->id;
                $itemdata['quantity'] = $item['quantity'];
                $itemdata['unit_price'] = $item['unit_price'];

                ReceptionProduct::create($itemdata);

                $stock = ProductWarehouse::where('product_id', $item['product_id'])
                    ->where('warehouse_id', $warehouse_id)
                    ->first();

                if (is_null($stock)) {
                    ProductWarehouse::create([
                        'quantity' => $item['quantity'],
                        'warehouse_id' => $warehouse_id,
                        'product_id' => $item['product_id'],
                    ]);
                }else{
                    $stock->increment('quantity', $item['quantity']);
                }

                OrderProduct::where('id', $item['id'])->update([
                    'quantity_received' => $item['quantity']
                ]);
            }

        }

        Order::where('id', $data['order_id'])->update([
            'status' => 3
        ]);
        return  $reception;
    }
}
