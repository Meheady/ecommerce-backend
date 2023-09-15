<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenRefresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return apiResponse('This is valid token');
        }
        catch (TokenExpiredException $expire) {
            return $next($request);
        }
        catch (TokenBlacklistedException $e) {
            return apiError($e->getMessage(),403);
        }
        catch (\Exception $e){
            return apiError($e->getMessage());
        }
    }
}
