<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Str;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerRepository extends Repository
{
   
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    
    public function customerList() {
        
        return Customer::where('customers.is_deleted', 0)
                        ->leftJoin('warehouses', 'warehouses.id', '=', 'customers.warehouse_id')
                        ->leftJoin('users', 'users.id', '=', 'customers.added_by')
                        ->selectRaw('warehouses.warehouse_name, customers.uuid, customers.full_name, customers.email, customers.phone, customers.avatar, customers.add_date, customers.created_at, CONCAT(users.first_name," ",users.last_name) as auteur, customers.id')
                        ->get();
    }

    public function storeCustomer(StoreCustomerRequest $request)  {
        
        $full_name = $request->full_name;
        $email = $request->email;
        $phone = $request->phone;
        $commentaire = $request->commentaire;
        $address = $request->address;

        $warehouse_id = (Auth::user()->assignedWarehouse) ? Auth::user()->assignedWarehouse->id : NULL ;

        $customer = Customer::create([
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

    public function updateCustomer(Request $request, $id)  {

    
        $customer = $this->model->find($id);

        $full_name = $request->full_name;
        $email = $request->email;
        $phone = $request->phone;
        $commentaire = $request->commentaire;
        $address = $request->address;
    
        $customer->update([
            'full_name' => Str::upper($full_name),
            'email' => $email,
            'phone' => $phone,
            'commentaire' => $commentaire,
            'address' => $address,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp(),
        ]);

        return $customer;

    }


    public function customer_select() {
        
        if (Auth::user()->warehouse) {

            $query = Customer::where('is_deleted', 0)
                    ->where('warehouse_id', Auth::user()->warehouse->id);
        }
        else
        {
            $query = Customer::where('is_deleted', 0)
                                ->whereNull('warehouse_id');
        }

        return $query->get();
    }


}