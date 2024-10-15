<?php

namespace App\Repositories;

use App\Models\ActivityArea;
use App\Repositories\Repository;

class ActivityAreaRepository extends Repository
{
    public function __construct(ActivityArea $model)
    {
        $this->model = $model;
    }

    public function activitySelect()  {
        
        return $this->model->where('is_deleted', 0)->selectRaw('id, name')->get();
    }

    public function updateStatusActivity($id){

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
