<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Http\Resources\Api\RoleResource;
use App\Http\Resources\Api\SelectRoleResource;
use App\Http\Resources\Api\select\UtilisateurParRole;

class RoleController extends Controller
{
    private $roleRepository;
    
    public function __construct(RoleRepository $roleRepository)
    {
      $this->roleRepository=$roleRepository;
    }

    public function index()
    {
        $resp = $this->roleRepository->roleList();

        return RoleResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $resp = $this->roleRepository->store_role($request);

        return new RoleResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $resp = $this->roleRepository->view_role($id);

        return response()->json(['data' => $resp]);
    }


    public function view_role($id) {
        
        $resp = $this->roleRepository->view_role($id);

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

        $resp = $this->roleRepository->update_role($request, $id);

        return new RoleResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->roleRepository->destroy($id);

        return new RoleResource($resp);
    }

    public function updateStatusRole($id) {
        
        $resp = $this->roleRepository->updateStatusRole($id);

        return new RoleResource($resp);
    }

    public function select_role()  {
        
        $resp = $this->roleRepository->select_role();

        return SelectRoleResource::collection($resp);
    }


    public function getUtilisateursParRole(Request $request) {
        
        $resp = $this->roleRepository->getUtilisateursParRole($request->role);

        return UtilisateurParRole::collection($resp);
    }
}
