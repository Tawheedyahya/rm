<?php

use App\Http\Middleware\JwtAuthMiddleware;
use App\Http\Middleware\Rolemiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'jwt.token'=>JwtAuthMiddleware::class,
            'role'=>Rolemiddleware::class
        ]);
        $middleware->api([
            SubstituteBindings::class
        ]);
        $middleware->redirectGuestsTo(fn () => null);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
         $exceptions->render(function (
            \Illuminate\Auth\AuthenticationException $e,
            $request
        ) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        });
        $exceptions->render(function(ThrottleRequestsException $e,$request){
            if($request->is('api/*')||$request->expectsJson()){
                return response()->json([
                    'success'=>false,
                    'message'=>'Too many attempts'
                ]);
            }
        },429);
    })->create();
