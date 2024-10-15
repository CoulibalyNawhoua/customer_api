<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use App\Http\Controllers\Controller;
use App\Repositories\UnitRepository;
use App\Http\Resources\Api\UnitResource;
use App\Http\Resources\Api\SelectResource;

class UnitController extends Controller
{

    protected $unitRepository;


    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resp = $this->unitRepository->getModelNotDelete();

        return UnitResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $resp = $this->unitRepository->storeUnit($request);

        return new UnitResource($resp);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $resp = $this->unitRepository->view($id);

        return new UnitResource($resp);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, $id)
    {

        
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $resp = $this->unitRepository->updateUnit($request, $id);

        return new UnitResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resp = $this->unitRepository->delete($id);

        return new UnitResource($resp);
    }

    public function unitSelect() {

        $resp = $this->unitRepository->unitSelect();

        return SelectResource::collection($resp);
    }
}
