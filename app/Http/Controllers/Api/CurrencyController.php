<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CurrencyResource;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository) {

        $this->currencyRepository = $currencyRepository;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resp = $this->currencyRepository->getModelNotDelete();

        return CurrencyResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $resp = $this->currencyRepository->create($request->all());

        return new CurrencyResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resp = $this->currencyRepository->view($id);

        return response()->json(['data' => $resp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $resp = $this->currencyRepository->update($request->all(), $id);

        return new CurrencyResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->currencyRepository->delete($id);

        return new CurrencyResource($resp);
    }

    public function updateStatusCurrency($id) {
        
        $resp = $this->currencyRepository->updateStatusCurrency($id);

        return new CurrencyResource($resp);
    }
}
