<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository extends Repository
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function roleList()  {
        
        return Role::all();
    }

    public function store_role(Request $request)
    {


        $role = $this->model->create([
            'name'=>$request->name
        ]);

        $role->syncPermissions($request->permission);

        return $role;
    }


    public function update_role(Request $request, $id)
    {
        $role = $this->model->find($id);

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permission);

        return $role;

    }

    public function destroy($id)
    {

        $role = $this->model->find($id);
        $role->update([
            'status' => 1
        ]);

        return $role;
    }


    public function view_role(string $id)
    {
        $role = Role::find($id);

        // $permission = Permission::get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();

        $data['role'] = $role;
        // $data['permission'] = $permission;
        $data['rolePermission'] = $rolePermissions;

        return $data;
    }

    public function updateStatusRole($id) {

        $data = $this->model->find($id);

        if ($data->status == 1) {
            
            $data->update([
                'status'=>0
            ]);
        }
        else{
            $data->update([
                'status'=>1
            ]);
        }
  
        return $data;
     }

     public function select_role() {
        
        $query = Role::all();

        return $query;
     }

    
}
