<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * Ensures:
     * 1. Token is present
     * 2. Token is valid and not expired
     * 3. Token is an access token (type='access')
     * 4. User exists
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Parse the token from Authorization header
            $token = JWTAuth::parseToken();
            
            // Get the payload
            $payload = $token->getPayload();
            
            // Check if this is an access token (not a refresh token)
            $tokenType = $payload->get('type');
            if ($tokenType !== 'access') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access token required. Use /token/refresh to get a new access token.'
                ], 401);
            }
            
            // Authenticate and get the user
            $user = $token->authenticate();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 401);
            }
            
            // Token is valid, continue to the route
            return $next($request);
            
        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired',
                'hint' => 'Use /token/refresh endpoint with your refresh_token to get a new access token'
            ], 401);
            
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid'
            ], 401);
            
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token not provided',
                'hint' => 'Add header: Authorization: Bearer YOUR_ACCESS_TOKEN'
            ], 401);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication error',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred'
            ], 500);
        }
    }
}