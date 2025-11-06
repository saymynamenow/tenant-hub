<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tenant\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('tenant')->attempt($credentials)) {
            $user = Auth::guard('tenant')->user();
            return response()->json(['message' => 'Login successful', 'user' => $user], 200);
        }
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function me()
    {
        $user = Auth::guard('tenant')->user();
        return response()->json(['user' => $user], 200);
    }
    public function logout()
    {
        Auth::guard('tenant')->logout();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
