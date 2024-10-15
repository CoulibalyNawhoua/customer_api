<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\Api\BrandResource;
use App\Http\Resources\Api\SelectResource;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{

    protected $brandRepository;


    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resp = $this->brandRepository->getModelNotDelete();

        return BrandResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $resp = $this->brandRepository->create($request->all());

        return new BrandResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resp = $this->brandRepository->view($id);

        return new BrandResource($resp);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, $id)
    {
        $resp = $this->brandRepository->update($request->all(), $id);

        return new BrandResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resp = $this->brandRepository->delete($id);

        return new BrandResource($resp);
    }

    public function brandSelect()  {

        $resp = $this->brandRepository->brandSelect();

        return SelectResource::collection($resp);
    }
}
