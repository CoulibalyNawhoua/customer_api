<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ZoneRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\ZoneResource;
use App\Models\Zone;

class ZoneController extends Controller
{

    private $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->zoneRepository=$zoneRepository;
    }

    public function index()
    {
        $resp = $this->zoneRepository->getModelNotDelete();

        return ZoneResource::collection($resp);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'amount' => 'numeric|min:2',
        ]);

        $resp = $this->zoneRepository->create($request->all());

        return new ZoneResource($resp);
    }
   

    public function show(string $id)
    {
        $resp = $this->zoneRepository->edit($id);

        return response()->json(['data'=>$resp]);
    }

   
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'name' => 'required',
            'amount' => 'numeric|min:2',
        ]);
        
        $resp = $this->zoneRepository->update($request->all(), $id);

        return new ZoneResource($resp);
    }

   
    public function destroy(string $id)
    {
        $resp = $this->zoneRepository->delete($id);

        return new ZoneResource($resp);
    }

    public function updateStatusZone($id) {
        
        $resp = $this->zoneRepository->updateStatusZone($id);

        return new ZoneResource($resp);
    }

    public function select_zone() {
        
        $resp  = $this->zoneRepository->select_zone();

        return response()->json(['data'=> $resp]);
    }


    public function warehouse_zone_price() {
        
        $warehouse = Auth::user()->warehouse;

        $zone = Zone::where('id',  $warehouse->warehouse_zone_id)->first();

        return response()->json(['data' => $zone->amount]);
    }
}
