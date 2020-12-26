<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup']]);
    }

    public function profile()
    {
        $user = auth()->user();
        return  response()->json($user);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $token = null;

        if (!$token = Auth::attempt($validatedData)) {
            return response()->json(['message' => 'Invalid Email or Password'], 401);
        }
        return  response()->json(['token' => $token]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     */
    public function signup(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        $token = Auth::login($user);
        $user['token'] = $token;

        return  response()->json($user, 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return  response()->json(['message' => 'Successfully logged out']);
    }
}
