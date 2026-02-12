<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required',],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required',],
        ]);

        $user = User::query()->create($validatedData);
        $token = $user->createToken('admin_token', ['admin'])->plainTextToken;

        return response()->json([
            'admin' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required' , 'email'],
            'password' => ['required'],
        ]);

        $user = User::query()->where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["message" => "Invalid Credentials"]);
        }

        $token = $user->createToken('admin_token', ['admin'])->plainTextToken;
        return response()->json(["admin" => $user, "token" => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(["message" => "Logged out"]);
    }
}


