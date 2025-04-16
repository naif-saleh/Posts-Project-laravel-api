<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Check if validation fails
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
                'code' => 422,
            ]);
        }

        // Create User data
        $user = User::Create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Create User token
        $token = $user->createToken('auth_token')->plainTextToken;

        // reurn response
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
            'code' => 201,
        ]);
    }

    public function login(Request $request)
    {
        // Validate Teh Request Data
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        // Check if validation fails
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
                'code' => 422,
            ]);
        }

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        $password =Hash::check($request->password, $user->password);
        if (!$user || !$password) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
                'code' => 401,
            ]);
        }

        // Create User token
        $token = $user->createToken('auth_token')->plainTextToken;

        // return response
        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token,
            'code' => 200,
        ]);

    }

    public function logout(Request $request)
    {
        // Delete User Current Access Token
       $token = $request->user()->currentAccessToken();

       //Check if token exists
       if(!$token){
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized Token 404',
                'code' => 401,

            ]);
       }
       $token->delete();
        // return response
        return response()->json([
            'status' => true,
            'message' => 'User Logged-Out Successfully',
            'code' => 200,
        ]);

    }
}
