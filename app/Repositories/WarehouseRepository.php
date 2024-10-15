<?php

namespace App\Repositories;

use App\Models\Warehouse;
use App\Models\Zone;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class WarehouseRepository extends Repository
{
   
    public function __construct(Warehouse $model)
    {
        $this->model = $model;
    }

    public function user_warehouse(){

        $query = Warehouse::selectRaw('warehouses.warehouse_logo, warehouses.warehouse_raison_sociale, warehouses.warehouse_address, warehouses.warehouse_email, warehouses.warehouse_postal_code, warehouses.warehouse_rccm, warehouses.warehouse_ncc, warehouses.num_Identification_fiscale, warehouses.warehouse_name, warehouses.activity_id')
                ->leftJoin('activities', 'activities.id', '=', 'warehouses.activity_id')
                ->where('warehouses.user_id', Auth::user()->id)
                ->firstOrFail();

        return $query;
    }

    public function update_user_warehouse (Request $request){

        $warehouse = Warehouse::where('user_id', Auth::user()->id)->first();

        $oldFile = $warehouse->warehouse_logo;
        $directory = 'warehouses';
        $fieldname = 'warehouse_logo';


        $data_file = $this->fileUpload($request, $fieldname, $directory, $oldFile);

        $image_url = $data_file;


        $warehouse->update([
            'warehouse_name' => $request->warehouse_name,
            'warehouse_address' => $request->warehouse_address,
            'warehouse_email' => $request->warehouse_email,
            'warehouse_phone' => $request->warehouse_phone,
            'num_Identification_fiscale' => $request->num_Identification_fiscale,
            'warehouse_logo' => $image_url
        ]);

        return $warehouse;

    }


    public function warehouse_select() {
        

        $warehouses = Warehouse::select('id','warehouse_name')->get();

        return $warehouses;
    }

    public function shop_select()  {
        
        $warehouses = Warehouse::select('id','warehouse_name')->get();

        return $warehouses;
    }

    public function warehouse_zone($id)
    {
        $warehouse = $this->model->find($id);

       return Zone::where('id', $warehouse->warehouse_zone_id)->select('amount')->first();
    }


}
