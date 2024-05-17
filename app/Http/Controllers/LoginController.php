<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    use HasApiTokens;

    public function check(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|string|required',
            'password' => 'string|required'
        ]);

        $credentials = $request->only('email', 'password');

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
                'token' => 'User does not exist',
                'user' => 'User does not exist',
                'status' => 404
            ], 404);
        }
    }
}
