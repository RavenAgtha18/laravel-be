<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'message' => 'login failed'
            ], 400);
        }
    
        $token = Auth::user()->createToken('authToken')->accessToken;
    
        return response()->json([
            'status' => true,
            'message' => 'login successful',
            'user' => Auth::user(),
            'token' => $token
        ], 200);
    }
    
    public function profile()
    {
        return response()->json([
            'status' => true,
            'message' => 'Successfully checked user profile.',
            'user' => Auth::user()], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'status' => true,
            'message' => 'you have successfully logged out'
        ], 200);
    }

}