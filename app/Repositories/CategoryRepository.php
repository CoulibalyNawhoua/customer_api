<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;

class CategoryRepository extends Repository
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }


    public function storeCategory(Request $request) {


        $oldFile = '';
        $directory = 'categories';
        $fieldname = 'image';

        $data_file = $this->fileUpload($request, $fieldname, $directory, $oldFile);

        $image_url = $data_file;

        $query = Category::create([
            'name'=> Str::of($request->name)->upper(),
            'comment' => $request->comment,
            'image_url' => $image_url,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp()
        ]);

        return $query;
    }

    public function categoryShowByUuid($category){

        return Category::whereUuid($category)->first();
    }


    public function updateCategory(Request $request, $id) {

        $category = $this->model->find($id);

        $oldFile =  ($category->image_url) ? $category->image_url : '' ; 
        $directory = 'categories';
        $fieldname = 'image';

        $data_file = $this->fileUpload($request, $fieldname, $directory,$oldFile);

        $image_url = $data_file;

        $category->update([
            'name'=>  Str::of($request->name)->upper(),
            'comment' => $request->comment,
            'image_url' => $image_url,
            'edited_by' => Auth::user()->id,
            'edit_ip' => $this->getIp(),
            'edit_date' => Carbon::now()
        ]);

        return $category;
    }


    public function categoryList(){

        return Category::where('is_deleted', 0)->get();
    }


    public function selectCategory() {

        return Category::where('is_deleted',0)->select('name','id')->get();

        // return Category::where('is_deleted', 0)->select(['id', 'name as text'])->get();
    }






}
