<?php

namespace App\Repositories;

use App\Models\PaymentType;
use App\Repositories\Repository;

class PaymentTypeRepository extends Repository
{
    /**
     * @return string
     *  Return the model
     */
    public function __construct(PaymentType $model)
    {
        $this->model=$model;
    }


    public function updateStatusPayment($id)  {
        
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
}
