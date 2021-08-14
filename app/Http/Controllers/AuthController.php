<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'username' => 'required|unique:users|min:3',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password'))
        ]);
    }

    /**
     * @api {post} /auth/login Login
     * @apiName Login
     * @apiGroup Auth
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiParam {String} username
     * @apiParam {String} password
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *       {
     *       "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9ncm91cGlwbS1hcGkudGVzdFwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MTU5NzY2NjAsImV4cCI6MTYxNTk4MDI2MCwibmJmIjoxNjE1OTc2NjYwLCJqdGkiOiJzb0hDcXpsTW44NjhXelZXIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.G5P8DzMXQeJlXj1Fgt_-kgv_m4_zAO3eTnD2u5xza5E",
     *       "token_type": "bearer",
     *       "expires_in": 3600
     *       }
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @api {post} /auth/refresh Return refreshed token auth
     * @apiName Refresh token
     * @apiGroup Auth
     *
     * @apiHeader {String} Token Auth token.
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *       {
     *       "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9ncm91cGlwbS1hcGkudGVzdFwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MTU5NzY2NjAsImV4cCI6MTYxNTk4MDI2MCwibmJmIjoxNjE1OTc2NjYwLCJqdGkiOiJzb0hDcXpsTW44NjhXelZXIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.G5P8DzMXQeJlXj1Fgt_-kgv_m4_zAO3eTnD2u5xza5E",
     *       "token_type": "bearer",
     *       "expires_in": 3600
     *       }
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
