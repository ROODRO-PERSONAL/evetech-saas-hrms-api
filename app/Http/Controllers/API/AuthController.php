<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // registraion process
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'company_email' => 'required|email|unique:companies,email',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Create company
        $company = Company::create([
            'name' => $request->company_name,
            'email' => $request->company_email,
        ]);

        // Create user
        $user = User::create([
            'company_id' => $company->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate token
         $token = Auth::login($user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }

    // logout process
    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    // testing token
    public function me()
    {
        return response()->json(Auth::user());
    }
}
