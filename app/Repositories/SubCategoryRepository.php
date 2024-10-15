<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class SubCategoryRepository extends Repository
{
    public function __construct(SubCategory $model)
    {
        $this->model = $model;
    }


    public function selectSubCategoryByCategory($category) {

        return $this->model->where('category_id', $category)->select('id', 'name')->get();
    }


    public function storeSubCategory(Request $request) {


        $query = SubCategory::create([
            'name'=> Str::of($request->name)->upper(),
            'comment' => $request->comment,
            'category_id' => $request->category_id,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp()
        ]);

        return $query;
    }

    public function updateSubCategory(Request $request, $id) {

        $subcategory = $this->model->find($id);

     

        $subcategory->update([
            'name'=>  Str::of($request->name)->upper(),
            'comment' => $request->comment,
             'category_id' => $request->category_id,
            'edited_by' => Auth::user()->id,
            'edit_ip' => $this->getIp(),
            'edit_date' => Carbon::now()
        ]);

        return $subcategory;
    }

}
