<?php

namespace App\Http\Controllers\Api;

use App\Constants\Message;
use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Tymon\JWTAuth\JWTAuth;
use JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            $user = auth()->user();
            if ($user->deleted_at == null) {
                $user['token'] = $token;
                $user['profile'] = $user->profile;
                return $this->dataSuccess(Message::SUCCESS, $user, StatusCode::SUCCESS);
            } else {
                return $this->dataSuccess('Email không tồn tại vui lòng kiểm tra lại', false, StatusCode::UNAUTHORIZED);
            }
        }
        return $this->dataError('Tài khoản hoặc mật khẩu không đúng', false, StatusCode::UNAUTHORIZED);
    }

    public function getUser()
    {
        $user = JWTAuth::user();
        $user['profile'] = $user->profile;
        $user['role'] = $user->role;
        try {
            if ($user) {
                return $this->dataSuccess(Message::SUCCESS, $user, StatusCode::SUCCESS);
            } else {
                return $this->dataError("token fail", false, StatusCode::BAD_REQUEST);
            }
        } catch (Exception $e) {
            return $this->dataError(Message::SERVER_ERROR, $e, StatusCode::SERVER_ERROR);
        }
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
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
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}