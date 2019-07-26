<?php

namespace App\Http\Controllers\Api;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validatedPayload = $request->validate([
            'name'=>'required|max:50',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);

        $validatedPayload['password'] =  bcrypt($request->password);
        $user = User::create($validatedPayload);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);

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
