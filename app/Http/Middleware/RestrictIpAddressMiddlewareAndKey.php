<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Key;
use App\Models\LogError;

class RestrictIpAddressMiddlewareAndKey
{
    public $restrictedIpTo = ['127.0.0.1'];

    public function handle($request, Closure $next)
    {
       
        if( !in_array( $request->ip(), $this->restrictedIpTo ) ){

            return response()->json(['message' => "You are not allowed to access this site."],401);

        }

        if(empty($request->header("Authorization"))){

            return response()->json(['message' => "You are not allowed to access this site."],401);

        }

        $token = $request->header("Authorization");
        $token = str_replace("Bearer ","",$token);

        if($token != env("KEY","")){

            return response()->json(['message' => "You are not allowed to access this site."],401);

        }
       
        return $next($request);
    }  
}
