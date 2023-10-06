<?php

namespace App\Http\Controllers;

use App\Domains\SuperUsersDomain;
use App\Http\Requests\LoginUserRequest;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller implements SuperUsersDomain
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => ['required', 'email', 'string'],
            'password' => ['required'],
            'remember' => ['boolean']
        ]);

        $remember = $credential['remember'] ?? false;

        unset($credential['remember']);

        if (!Auth::attempt($credential, $remember)) {
            return $this->error('Usuário e/ou senha inválido(s)', 422);
        }

        $user = Auth::user();

        $user->load("personal");
        
        $token = $user->createToken(env('APP_NAME'))->plainTextToken;


        unset($user['created_at'], $user['email_verified_at'], $user['updated_at']);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return response()->json(['success' => true]);
    }
}
