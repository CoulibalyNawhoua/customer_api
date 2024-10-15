<?php

namespace App\Repositories;

use App\Models\Zone;
use App\Models\Store;
use App\Models\DeliveryZone;
use App\Repositories\Repository;

class ZoneRepository extends Repository
{
   function __construct(Zone $model)
   {
        $this->model=$model;
   }


   public function updateStatusZone($id) {
      
      
      $data = $this->model->find($id);

      if ($data->status == 1) {
          
          $data->update([
              'status'=>0
          ]);
      }
      else{
          $data->update([
              'status'=>1
          ]);
      }

      return $data;
   }

   public function select_zone() {

        $query = Zone::selectRaw('id, name, amount')->get();

        return $query;
   }

}
