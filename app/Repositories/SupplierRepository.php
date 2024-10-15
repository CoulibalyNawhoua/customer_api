<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;


class SupplierRepository extends Repository
{
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    public function supplierList() {
        
        return Supplier::where('suppliers.is_deleted', 0)
                        ->leftJoin('warehouses', 'warehouses.id', '=', 'suppliers.warehouse_id')
                        ->leftJoin('users', 'users.id', '=', 'suppliers.added_by')
                        ->selectRaw('warehouses.warehouse_name, suppliers.uuid, suppliers.full_name, suppliers.email, suppliers.phone, suppliers.avatar, suppliers.add_date, suppliers.created_at, CONCAT(users.first_name," ",users.last_name) as auteur, suppliers.id')
                        ->get();
    }

    public function storeSupplier(Request $request)  {
        
        $full_name = $request->full_name;
        $email = $request->email;
        $phone = $request->phone;
        $commentaire = $request->commentaire;
        $address = $request->address;

        $warehouse_id = (Auth::user()->assignedWarehouse) ? Auth::user()->assignedWarehouse->id : NULL ;

        $customer = Supplier::create([
            'full_name' => Str::upper($full_name),
            'email' => $email,
            'phone' => $phone,
            'commentaire' => $commentaire,
            'address' => $address,
            'warehouse_id' => $warehouse_id,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp(),
        ]);

        return $customer;

    }

    public function updateSupplier(Request $request, $id)  {

       
        
        $supplier = $this->model->find($id);

        $full_name = $request->full_name;
        $email = $request->email;
        $phone = $request->phone;
        $commentaire = $request->commentaire;
        $address = $request->address;
    
        $supplier->update([
            'full_name' => Str::upper($full_name),
            'email' => $email,
            'phone' => $phone,
            'commentaire' => $commentaire,
            'address' => $address,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp(),
        ]);

        return $supplier;

    }


    public function supplierSelect() {

        return Supplier::where('is_deleted', 0)->selectRaw('id, full_name')->get();
    }


    public function supplier_warehouse() {
        
        $warehouse_id = (Auth::user()->assignedWarehouse) ? Auth::user()->assignedWarehouse->id : NULL ;

        return Supplier::where('warehouse_id', $warehouse_id)
                        ->where('is_deleted', 0)
                        ->where('added_by', Auth::user()->id)
                        ->get();
    }

    public function supplierSelectWarehouse() {

        $warehouse_id = (Auth::user()->assignedWarehouse) ? Auth::user()->assignedWarehouse->id : NULL ;

        return Supplier::where('is_deleted', 0)
                        ->where('warehouse_id', $warehouse_id)
                        ->where('added_by', Auth::user()->id)
                        ->selectRaw('id, full_name')->get();
    }

}
