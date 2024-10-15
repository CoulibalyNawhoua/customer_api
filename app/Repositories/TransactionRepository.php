<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Delivery;
use App\Models\Transaction;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;



class TransactionRepository extends Repository
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function create_transation($uuid) {
        
        $user = Auth::user();
        
        $query = Delivery::selectRaw('warehouses.warehouse_name, deliveries.total_amount, warehouses.id AS warehouse_id, deliveries.reference AS delivery_reference')
                        ->leftJoin('users AS delivery_person', 'delivery_person.id', '=', 'deliveries.delivery_person_id')
                        ->leftJoin('warehouses', 'warehouses.id', '=', 'deliveries.warehouse_id')
                        ->where('deliveries.uuid', $uuid)
                        ->first();

        $formData = [
            'transaction_id' => $this->transactionCode('Transaction'),
            'customer_name' => $query->warehouse_name,
            'customer_id' => $query->warehouse_id,
            'distri_seller_name' => $user->full_name,
            'distri_seller_id' => $user->id,
            'plateforme_name' => 'DISTRIFORCE CUSTOMER',
            'description' => 'Encaissement livraisont',
            'transaction_date' => Carbon::now()->format('Y-m-d'),
            'amount' => $query->total_amount,
            'delivery_reference' => $query->delivery_reference

    
        ];
    
        return $formData;
    }
    
}
