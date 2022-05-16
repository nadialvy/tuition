<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
// use Illuminate\Support\Facades\DB;
USE Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('email', 'password'); 

        try{
            if( ! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Email and password are incorrect'], 200);
            }
        }catch(JWTException $e) {
            return response()->json(['message' => 'Email and password are incorrect'], 200);
        }

        $data = User::where('email', '=', $request->email)-> get();
        return response()->json([
            'status' => 1,
            'message' => 'Succes login!',
            'token' => $token,
            'data' => $data
        ]);
    }

    public function register(Request $request){
        $validator=Validator::make($request->all(), 
        [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', //unique untuk mengecek, users adalah nama tabel
                                                                    //ketika validator, sebelum insert data, akan dicek apakah email nya sudah ada di tabel user
                                                                    //jadi tidak boleh ada email yang samma
            'password' => 'required|string|min:6|confirmed', //confirmed artinya harus ada password confirmation
            'type' => 'required|string'
        ]);

        if($validator->fails()){
            return response() -> json($validator->errors()->toJson(), 400);
        }
        
        $user=User::create(
            [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'type' => $request->type
            ]
        );

        $token=JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
    }


    public function getAuthenticatedUser(){
        try{
            if( ! $user=JWTAuth::parseToken()->authenticate() ){
                return response() -> json(['user not found'], 400);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return Response()->json(['token_expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return Response()->json(['token_invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e){
            return Response()->json(['token_absent'], 401);
        }

        return Response()->json([
            compact('user'),
            'status' => 1,
            'message' => 'Success login!'
        ]);

        
    }
}
