<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

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
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        // dd($token);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data=[
            'user_id' => auth('api')->user()->id,
            'random'=> rand() . time(),
            'exp'=> time()+config('jwt.refresh_ttl')
        ];

        $refreshToken=JWTAuth::getJWTProvider()->encode($data);
        return $this->respondWithToken($token,$refreshToken);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        try{
            return response()->json(auth('api')->user());
        }catch(JWTException $e){
            return response()->json(['error'=>'Unauthorized',401]);
        }
        
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $refreshToken=request()->refresh_token;
        
        try{
            $decode=JWTAuth::getJWTProvider()->decode($refreshToken);
            $user=User::find($decode['user_id']);
            if(!$user){
                return response()->json(['error'=>'User not found'],404);
            }
            else{
                //Lưu ý
                auth('api')->invalidate();
                $token=auth('api')->login($user);
                $refreshToken=$this->createRefreshToken();
                return $this->respondWithToken($token,$refreshToken);
            }

            return response()->json(($decode));
        }catch(Exception $e)
        {
            return response()->json(['error'=>'Refresh token Invalid'],500);
        }
        
    }

    public function createRefreshToken(){
        $data=[
            'user_id'=> auth('api')->user()->id,
            'random'=>rand().time(),
            'exp'=>time() + config('jwt.refresh_ttl')
        ];
        
        $refreshToken=JWTAuth::getJWTProvider()->encode($data);
        return $refreshToken;
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token'=>$refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}