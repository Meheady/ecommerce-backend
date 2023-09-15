<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class UserAuthenticationController extends Controller
{
    /**
     * @throws \Exception
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if ($token = auth('api')->attempt($credentials)) {

                $data = [
                    'token'=>$token,
                    'user'=> User::selectUser(Auth::id())
                ];
                return apiResponse($data);
            }
            else{
             throw new \Exception('You are not authenticate',401);
            }
        }
        catch (Exception $e){
            return apiError($e->getMessage(), $e->getCode());
        }

    }

    public function logout()
    {
        try {
            auth('api')->logout(true);
            return apiResponse('Successfully logged out');

        }catch (Exception $e){
            return apiError($e->getMessage(),$e->getCode());
        }
    }

    public function refreshToken()
    {
        try {
            $newToken = auth('api')->refresh();
            return response()->json([
                "token"=>$newToken
            ]);
        }
        catch (\Exception $e){
            return response()->json(['error' => 'Token has been blacklisted'], 403);
        }
    }
}
