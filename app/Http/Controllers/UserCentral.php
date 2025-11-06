<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class UserCentral extends Controller
{
    public function loginCentralUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Central user login successful',
                'user' => $user
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    public function logoutCentralUser(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Central user logged out successfully'], 200);
    }

    public function meCentralUser(Request $request)
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    public function registerCentralUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'message' => 'Central user registered successfully', 
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
            ]
        ], 201);
    }
}
