<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string',
            ]);
        } catch(\Exception $e){
            return $e->getMessage();
        }
        $user = new User([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();
        return response('Usuario creado correctamente!', 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user == null || ! Hash::check($request->password, $user->password)) {
            return response(ValidationException::withMessages([
                'email' => ['El correo no existe en nuestro registro.'],
                'password' => ['La contraseña no es correcta.'],
            ])->getMessage(), 401);
        }
        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMinutes(30);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at)
                ->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response('Sesion correctamente cerrada.', 200);
    }

    public function unauthorized(){
        return response('No esta autorizado, por favor loguearse e intentar nuevamente', 401);
    }

    public function getUser(){
        return auth()->user();
    }
}
