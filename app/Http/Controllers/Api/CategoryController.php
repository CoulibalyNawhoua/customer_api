<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Http\Resources\Api\SelectResource;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\EditCategoryResource;

class CategoryController extends Controller
{
    protected $categoryRepository;


    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function index()
    {
        $query  = $this->categoryRepository->getModelNotDelete();

        return  CategoryResource::collection($query);
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif'
        ]);

        $resp = $this->categoryRepository->storeCategory($request);

        return new CategoryResource($resp);
    }


    public function show($category)
    {
        $resp = $this->categoryRepository->view($category);

        return new EditCategoryResource($resp);
    }


    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif'
        ]);

        $resp = $this->categoryRepository->updateCategory($request, $id);

        return new CategoryResource($resp);

    }


    public function destroy($category)
    {
        $resp = $this->categoryRepository->delete($category);

        return new CategoryResource($resp);
    }

    public function categorySelect() {

        $resp = $this->categoryRepository->selectCategory();

        return SelectResource::collection($resp);

        // return response()->json($resp);
    }


}
