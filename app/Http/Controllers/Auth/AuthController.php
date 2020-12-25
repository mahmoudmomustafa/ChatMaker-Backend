<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($data)) {
            return response()->json([
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     */
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = Auth::login($user);

        $user = $user->toArray();
        $user['token'] = $token;

        return response()->json($user, 201);
    }
}
