<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login( AuthLoginRequest $request )
    {
        $credentials = $request->validated();

        if( !Auth::attempt($credentials) ){
            return response([
                'message' => 'Correo o contraseña incorrectos'
            ], 422);
        }

        $user = User::find(Auth::user()['id']);
        $token = $user->createToken('token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }



    //? REGISTRAR UN NUEVO USUARIO
    public function register( AuthRegisterRequest $request )
    {
        $request->validated();

        $user = User::create($request->all());
        return $user;
    }


    public function logout( Request $request )
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response([
            'message' => 'Se cerro la sesion'
        ], 200);
    }
}
