<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // Create Token
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user
            ]);

        } catch (QueryException $e) {
            // Database error
            return response()->json([
                'status' => false,
                'message' => 'Database error: '.$e->getMessage()
            ], 500);
        } catch (Exception $e) {
            // General error
            return response()->json([
                'status' => false,
                'message' => 'Error: '.$e->getMessage()
            ], 500);
        }
    }
}
