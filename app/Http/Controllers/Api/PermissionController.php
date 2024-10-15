<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PermissionResource;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    
    private $permissionRepository;
    
    public function __construct(PermissionRepository $permissionRepository)
    {
      $this->permissionRepository=$permissionRepository;
    }

    public function index()
    {
        $resp = $this->permissionRepository->permissionList();

        return PermissionResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        
        $resp = $this->permissionRepository->store_permission($request);

        return new PermissionResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resp = $this->permissionRepository->view($id);

        return response()->json(['data' => $resp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        
        $resp = $this->permissionRepository->update_permission($request, $id);

        return new PermissionResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->permissionRepository->delete_permission($id);

        return new PermissionResource($resp);
    }
}
