<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token =$user->createToken($request->token_name)->plainTextToken;
            return response()->json(['message' => 'Login successful', 
            'token' => $token,
            'userId'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email
        
        ], 200);
        }

        return response()->json(['error' => 'The provided credentials do not match our records.'], 401);
    }
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out'], 200);
    }
}

