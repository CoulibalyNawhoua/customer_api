<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends Repository
{
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function permissionList() {
        
        $query = Permission::all();

        return $query;
    }

    public function store_permission(Request $request)  {
        
        $query = Permission::create([
            'name' => $request->name
        ]);

        return $query;
    }


    public function update_permission(Request $request, $id)  {
        
        $permission = $this->model->find($id);

        $permission->update([
            'name' => $request->name
        ]);

        return $permission;
    }


    public function delete_permission($id)  {
        
        $permission = $this->model->find($id);

        $permission->delete();

        return $permission;
    }



}
