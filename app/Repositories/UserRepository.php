<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }


    public function userList(){
        
        $query = User::selectRaw('users.full_name, users.email, users.created_at, users.active, users.id, users.type_user')
                ->where('type_user', 'web')
                ->get();

        return $query;
                      
    }

    public function storeUser(Request $request)  {
        
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type_user' => 'web',
        ]);

        $user->assignRole($request->input('role'));


        UserInfo::create([
            'user_id' => $user->id,
            'personal_phone' =>  $request->input('personal_phone')
        ]);

        return $user;
    }


    public function deleteUser($id) {
        

        $user =  $this->model->find($id);
        $user->delete();

        return $user;
    }

    public function update_user(Request $request, $id) {
        
        $user = $this->model->find($id);

        $input = $request->all();

        $input = Arr::except($input,array('email'));

        $user->update($input);


        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($input['role']);


        $user->info->update([
            'personal_phone' => $input['personal_phone']
        ]);

        return $user;
    }


    public function update_password(Request $request, $id) {
        
        $user = $this->model->find($id);

        $input = $request->all();

        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
        $user->update($input);

        return $user;
    }


    public function view_user($id) {
        
        $user = User::find($id);

        $userInfo = $user->info;

        if ($userInfo === null) {
            // create new model
            $userInfo = UserInfo::create(['user_id' => $id]);
        }

        $userRole = $user->getRoleNames()[0]  ?? '';

        return $data = [
            'user'=>$user,
            'userRole'=>$userRole,
            'userInfo' => $userInfo
        ];
    }

    public function updateStatusUser($id) {
        
        
      $data = $this->model->find($id);

      if ($data->active == 1) {
          
          $data->update([
              'active'=>0
          ]);
      }
      else{
          $data->update([
              'active'=>1
          ]);
      }

      return $data;
    }

}
