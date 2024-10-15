<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class CurrencyRepository extends Repository
{
   public function __construct(Currency $model)
   {
        $this->model=$model;
   }

   public function updateStatusCurrency($id){

      $data = $this->model->find($id);

      if ($data->statut == 1) {
          
          $data->update([
              'statut'=>0
          ]);
      }
      else{
          $data->update([
              'statut'=>1
          ]);
      }

      return $data;
   }

}