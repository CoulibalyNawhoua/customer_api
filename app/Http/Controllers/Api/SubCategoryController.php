<?php

namespace App\Http\Controllers\Api;

use App\Models\SubCategory;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Resources\Api\SelectResource;
use App\Repositories\SubCategoryRepository;
use App\Http\Resources\Api\SubCategoryResource;

class SubCategoryController extends Controller
{
    protected $subCategoryRepository;


    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }

    public function index()
    {
        $resp = $this->subCategoryRepository->getModelNotDelete();

        return SubCategoryResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'category_id' => 'required'
        ]);

        $resp = $this->subCategoryRepository->storeSubCategory($request);

        return new SubCategoryResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resp = $this->subCategoryRepository->view($id);

        return response()->json(['data' => $resp]);
        // return new SubCategoryResource($resp);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required',
            'category_id' => 'required'
        ]);

        $resp = $this->subCategoryRepository->updateSubCategory($request, $id);

        return new SubCategoryResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resp = $this->subCategoryRepository->delete($id);

        return new SubCategoryResource($resp);
    }

    public function selectSubCategoryByCategory($category)  {

        $resp = $this->subCategoryRepository->selectSubCategoryByCategory($category);

        return SelectResource::collection($resp);
    }

}
