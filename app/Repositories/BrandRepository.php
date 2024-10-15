<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Repository;


class BrandRepository extends Repository
{
    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function brandSelect() {

        return Brand::where('is_deleted',0)->select('name','id')->get();
    }
}
