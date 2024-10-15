<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ActivityAreaResource;
use App\Repositories\ActivityAreaRepository;

class ActivityAreaController extends Controller
{
    private $activityAreaRepositor;
    
    public function __construct(ActivityAreaRepository $activityAreaRepositor)
    {
      $this->activityAreaRepositor=$activityAreaRepositor;
    }
    public function index()
    {
        $resp = $this->activityAreaRepositor->getModelNotDelete();

        return ActivityAreaResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        
        $resp = $this->activityAreaRepositor->create($request->all());

        return new ActivityAreaResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resp = $this->activityAreaRepositor->view($id);

        return response()->json(['data' => $resp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'name' => 'required|string',
        ]);
        
       
        $resp = $this->activityAreaRepositor->update($request->all(), $id);

        return new ActivityAreaResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->activityAreaRepositor->delete($id);

        return new ActivityAreaResource($resp);
    }

    public function activitySelect()  {
        
        $resp = $this->activityAreaRepositor->activitySelect();

        return response()->json(['data' => $resp]);
    }


    public function updateStatusActivity($id) {
        
        $resp = $this->activityAreaRepositor->updateStatusActivity($id);

        return new ActivityAreaResource($resp);
    }
}
