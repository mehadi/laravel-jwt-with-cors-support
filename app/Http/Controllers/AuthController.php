<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    /*User Registration*/
    public function register(UserRegisterRequest $request)
    {
        $request->merge([
            'password' => bcrypt($request->password)
        ]);

        $user = User::create($request->all());

        if (!$token = auth()->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithTokenAndData($token, new UserResource($user));
    }

    /*User Login*/
    public function login(UserLoginRequest $request)
    {
        if (!$token = auth()->attempt($request->only(['email', 'password']))) {
            return response()->json(
                [
                    'errors' => [
                        'email' => 'Sorry we can\'t find you!'
                    ]
                ]
                , 422);
        }

        return $this->respondWithTokenAndData($token, new UserResource($request->user()));
    }

    /*Logout a user*/
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /*Get details of logged in user*/

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    /*Refresh token*/
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'meta' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }

    protected function respondWithTokenAndData($token, $data)
    {
        return response()->json([
            'data' => $data,
            'meta' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }



}
