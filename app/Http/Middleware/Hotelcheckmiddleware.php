<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Hotelcheckmiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user=auth('api')->user();
        if(!$user||!$user->hotel_id){
            return response()->json([
                'success'=>false,
                'status'=>403,
                'message'=>'User is not assigned to hotel'
            ],403);
        }
        return $next($request);
    }
}
