<?php

namespace App\Http\Controllers\Api;
use App\User;
use App\Http\Resources\Users as UsersResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function index()
    {
        // Get Users
        // $User = User::orderBy('updated_at', 'desc')->paginate(10);
        $User = User::orderBy('computer_number', 'asc')->get();

        // Return collection of Users as a resource
        return UsersResource::collection($User);
    }

    public function show($id) 
    {
        // Get User
        $User = User::findOrFail($id);

        // Return single User as a resource
        return new UsersResource($User);
    }

    public function register(Request $request)
    {
        $validatedPayload = $request->validate([
            'name'=>'required|max:50',
            'email'=>'email|required|unique:users',
            'computer_number'=>'required',
            'password'=>'required|confirmed',
            'status_description'=>'required|max:100',
            'online'=>'required',
            'active'=>'required',
            
        ]);

        $validatedPayload['password'] =  bcrypt($request->password);
        $validatedPayload['active'] =  (int)($request->active === 'true');
        $user = User::create($validatedPayload);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);

    }

             /**
	 * Update-Action
	 *
	 * @param Request $request
	 * @param int $id
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, $id)
	{
       
        $User = User::findOrFail($id);

        $validatedPayload = $request->validate([
            'name'=>'required|max:50',
            'email'=>'email|required|unique:users,email,' . $id,
            'computer_number'=>'required',
            'password'=>'required|confirmed',
            'active'=>'required',
        ]);

        $validatedPayload['active'] =  (int)($request->active === 'true');
        // Check if the user updated his/her password
        if ($User["password"] === $request["password"]) {
            $validatedPayload['password'] = $User["password"];
        } else {
            $validatedPayload['password'] =  bcrypt($request->password);
        }
        
		$User->update($validatedPayload);
 
        return new UsersResource($User);
 
    }


    public function updateStatus(Request $request, $id)
	{
       
        $User = User::findOrFail($id);

        $validatedPayload = $request->validate([
            'status_description'=>'required|max:100',
        ]);
        
		$User->update($validatedPayload);
 
        return new UsersResource($User);
 
    }

    public function login(Request $request)
    {
        $validatedPayload = $request->validate([
            'email'=>'email|required',
            'password'=>'required'
        ]);


        if( !auth()->attempt($validatedPayload)) {
            return response([
                'message'=> 'You have entered your password or email incorrectly. Please check your password and  account email and try again.',
                'errors' => ['main' => true]], 422);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user'=> auth()->user(), 'token'=> $accessToken, 'authenticated' => true]);

    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });


        return response()->json('Logged out successfully', 200);

    }

}
