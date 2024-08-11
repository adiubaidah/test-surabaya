<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        $credentials = request(['username', 'password']);

        $user = User::where('username', $credentials['username'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
                'data' => null
            ], 401);
        }
        $token = $user->generateJwtToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'token' => 'Bearer ' . $token,
                'admin' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'email' => $user->email,
                ],
            ],
        ])->cookie('accessToken', $token, 60, null, env('APP_DEBUG') ? 'localhost' : ".adiiskandar.my.id", false, false);
    }

    public function logout()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful',
        ]);
    }
}
