<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use App\Models\AuthUser;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:auth_users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = AuthUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error('Registration Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $user = Auth::guard('web')->user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;
    
        return response()->json([
            'token' => $token
        ]);
    }
}
