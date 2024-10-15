<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\UserInfo;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $resp = $this->userRepository->userList();

        return UserResource::collection($resp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|',
            'password_confirmation' => 'required',
            'password_confirmation' => 'required|same:password',
            'role' => 'required',
        ]);


        $resp = $this->userRepository->storeUser($request);

        return new UserResource($resp);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function viewUser(string $id)
    {
        $resp = $this->userRepository->view_user($id);

        return response()->json(['data' => $resp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // $validated = $request->validate([
        //     'full_name' => 'required|string',
        //     'password' => 'same:',
        // ]);

        // $resp = $this->userRepository->update_user($request, $id);

        // return new UserResource($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = $this->userRepository->deleteUser($id);

        return new UserResource($resp);
    }

    public function userProfileUpdate(Request $request, $id) {
        

        $validated = $request->validate([
            'full_name' => 'required|string',
            'role' => 'required',
        ]);

        $resp = $this->userRepository->update_user($request, $id);

        return new UserResource($resp);
    }

    public function userPasswordUpdate(Request $request, $id) {
        
        $validated = $request->validate([
            'password' => 'required|same:confirmpassword',
        ]);

        $resp = $this->userRepository->update_password($request, $id);

        return new UserResource($resp);

    }


    public function updateStatusUser($id) {
        
        $resp = $this->userRepository->updateStatusUser($id);

        return new UserResource($resp);
    }


    public function user_profile()  {
        
        $user =  Auth::user();


        $info = UserInfo::where('user_id', auth()->user()->id)->first();

        if ($info === null) {
            // create new model
            $info = UserInfo::create(['user_id' => $user->id ]);
        }

        return $info;
    }
}
