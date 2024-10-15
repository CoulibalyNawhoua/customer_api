<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\AbilityResource;
use Illuminate\Validation\ValidationException;

class WebAuthController extends Controller
{
    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signin(Request $request){

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {

            throw ValidationException::withMessages([
                'email' => ['Les informations d\'identification fournies sont incorrectes']
            ]);
        }

        return $this->createNewToken($token);
    }

    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|confirmed|',
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->toJson()], 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        if (! $token = JWTAuth::attempt($request->only('email','password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()->full_name,
        ]);
    }

    public function me()
    {
        $user = Auth::user();

        // $data->permissions = $data->roles()->with('permissions')->get()
        //                     ->pluck('permissions')
        //                     ->flatten()
        //                     ->pluck('name')
        //                     ->toArray();

        


        // $permissions = auth()->user()->roles()->with('permissions')->get()
        //                 ->pluck('permissions')
        //                 ->flatten()
        //                 ->pluck('name')
        //                 ->toArray();

        // $data['permissions'] = $permissions;
        // $data['authUser'] = $authUser;

        
        return response()->json(['user'=> $user]);
    }


    public function web_user_auth_change_password(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['required','same:new_password'],
        ]);

        auth()->user()->update(['password' => Hash::make($request->input('new_confirm_password'))]);

        if ($request->expectsJson()) {
            return response()->json($request->all());
        }

    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
}
