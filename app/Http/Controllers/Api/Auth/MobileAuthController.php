<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MobileAuthController extends Controller
{
    public function mobile_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (! $token = JWTAuth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // $user = Auth::user();
        // $token = $user->createToken('MobileAppToken')->accessToken;

        return $this->createNewToken($token);
    }

    public function mobile_register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'phone_number' => 'required|unique:users',
            'password' => 'required|min:6',
            'warehouse_name' => 'required',
            'activity_id' => 'required',
            'warehouse_zone_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->toJson()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'type_user' => 'mobile',
            'password' => Hash::make($request->password)
        ]);

        Warehouse::create([
            'activity_id' => $request->activity_id,
            'warehouse_zone_id' => $request->warehouse_zone_id,
            'warehouse_name' => $request->warehouse_name,
            'user_id' => $user->id
        ]);

        return response()->json(['data'=> $user]);

        // if (! $token = JWTAuth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        // return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => Auth::user(),
            'warehouse' => $this->getAuthWarhouse(),
            'zone' => $this->getWarhouseZone(),
            'activity' => $this->getWarhouseActivity(),
            
        ]);
    }

    function getAuthWarhouse() {

        return  Auth::user()->warehouse;
    }

    function getWarhouseZone() {

        $warehouse = Auth::user()->warehouse;

        return   $warehouse->warehouse_zone;
    }

    function getWarhouseActivity() {

        $warehouse = Auth::user()->warehouse;
        
        return   $warehouse->warehouse_activity;
    }

    
    public function get_auth_user(Request $request)
    {
        return response()->json($request->user());
    }


    public function mobile_auth_refresh() {
        return $this->createNewToken(auth()->refresh());
    }
}
