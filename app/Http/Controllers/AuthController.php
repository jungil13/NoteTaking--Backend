<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 401
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $tokenValue = $request->input('tokenValue');
            $accessToken = PersonalAccessToken::findToken($tokenValue);

            if ($accessToken) {
                $accessToken->delete();
                return response()->json(['message' => 'Logout successful'], 200);
            } else {
                return response()->json(['message' => 'Token not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the token'], 500);
        }
    }
}
