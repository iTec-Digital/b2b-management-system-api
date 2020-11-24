<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        try {

            /**
             * Redirect the user to the expected request
             */
            if (auth()->check()) {

                //Check some information
                $auth_user = auth()->user();
                if($auth_user->IsActive == 0) {
                    return response()->json([
                        'success' => false,
                        'error_code' => 'ACCOUNT_BANNED',
                        'message' => 'Your account has been banned! Please contact the administrator!',
                    ], 403);
                }

                if($auth_user->IsDeleted == 1) {
                    return response()->json([
                        'success' => false,
                        'error_code' => 'ACCOUNT_DELETED',
                        'message' => 'Your account was deleted by the administrator!',
                    ], 403);
                }


                //Continue to the request
                return $next($request);
            }


            if (!$token = JWTAuth::parseToken()) {
                //throw an exception
                return response()->json([
                    'success' => false,
                    'error_code' => 403,
                    'message' => 'You are not authenticated!',
                ], 403);
            }
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                //throw an exception
                return response()->json([
                    'success' => false,
                    'error_code' => 'TOKEN_INVALID',
                    'message' => $e->getMessage(),
                ], 403);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                //throw an exception
                return response()->json([
                    'success' => false,
                    'error_code' => 'TOKEN_EXPIRED',
                    'message' => $e->getMessage(),
                ], 403);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                //throw an exception
                return response()->json([
                    'success' => false,
                    'error_code' => 'TOKEN_BLACKLISTED',
                    'message' => $e->getMessage(),
                ], 403);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                //throw an exception
                return response()->json([
                    'success' => false,
                    'error_code' => 'JWT_ERROR',
                    'message' => $e->getMessage(),
                ], 403);
            } else {
                //throw an exception
                return response()->json([
                    'success' => false,
                    'error_code' => 403,
                    'message' => $e->getMessage(),
                ], 403);
            }
        }

        return response()->json([
            'success' => false,
            'error_code' => 403,
            'message' => 'You are not authenticated!',
        ], 403);
    }
}
