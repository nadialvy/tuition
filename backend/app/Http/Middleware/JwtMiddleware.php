<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$types)
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
        } 
        catch(Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is invalid. Try Again!']);
            } 
            else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is expired']);
            }
            else{
                return response()->json(['status' => 'Authorizarion Token not found']);
            }
        }

        // return compact($user);

        if($user && in_array($user->type, $types)){
            return $next($request);
        }else {
            return response()->json(["Invalid role, your role", $user->type]);
        }
        
    }
}
