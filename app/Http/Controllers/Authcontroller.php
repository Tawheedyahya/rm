<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\DTOs\ResetDTO;
use App\Http\Requests\Loginrequest;
use App\Http\Requests\Registerrequest;
use App\Http\Requests\Resetpasswordrequest;
use App\Services\Authservice;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dedoc\Scramble\Attributes\Unauthenticated;
#[Group('AUTHENTICATION')]
class Authcontroller extends Controller
{
    public function __construct(private Authservice $authService) {}
    /**
     * LOGIN
     * @unauthenticated
     */
    public function login(Loginrequest $request): JsonResponse
    {
        $data = $this->authService->login(LoginDTO::fromRequest($request));

        if (! $data['success']) {
            return response()->json([
                'message' => $data['message']
            ], $data['status']);
        }

        return response()->json($data, $data['status'])
           ->cookie(
            'refresh_token',
            $data['refresh_token'],
            43200,
            '/',
            null,
            false,   
            true,
            false,
            'Lax'    
        );
    }
    /**
     * REGISTER
     * @unauthenticated
     */
    public function register(Registerrequest $request):JsonResponse
    {
        $data = $this->authService->register(RegisterDTO::fromRequest($request));

        if (! $data['success']) {
            return response()->json([
                'message' => $data['message']
            ], $data['status']);
        }

        return response()->json($data, $data['status'])
         ->cookie(
    'refresh_token',
    $data['refresh_token'],
    43200,
    '/',
    null,
    false,   // http → false
    true,
    false,
    'Lax'    // NOT None
);
    }
/**
 * REFRESH AND ACCESS TOKEN GENERATION
 */
    public function refresh(Request $request): JsonResponse
    {   try{
        $refreshToken =JWTAuth::parseToken()->getToken();
        if (! $refreshToken) {
            throw new \Exception('No refresh token provided');
        }
        }
        catch(\Exception $e){
            return response()->json([   
                'message' => $e->getMessage()
            ], 401);
        }
        $data = $this->authService->refresh($refreshToken);

        if (! $data['success']) {
            return response()->json([
                'message' => $data['message']
            ], $data['status']);
        }

        return response()->json($data, $data['status'])
            ->cookie(
            'refresh_token',
            $data['refresh_token'],
            43200,
            '/',
            null,
            false,   // http → false
            true,
            false,
            'Lax'    // NOT None
        );

    }
/**
 * PROFILE
 */
    public function profile(): JsonResponse
    {
        return response()->json([
            'user' => auth('api')->user(),
        ]);
    }
/**
 * LOGOUT
 */
    public function logout(Request $request): JsonResponse
    {
        $refreshToken = $request->input('refresh_token')
            ?? $request->header('X-Refresh-Token')
            ?? $request->cookie('refresh_token');

        $this->authService->logout($refreshToken);

        return response()->json([
            'message' => 'Logged out successfully'
        ])->cookie('refresh_token', '', -1);
    }
    /**
     * PASSWORD CHANGE
     * @unauthenticated
     */
    public function password_change(Request $request){
        $request->validate([
            'email'=>'required|string|email'
        ]);
        $data=$this->authService->password_change($request->email);
        if(!$data['success']){
            return response()->json([
                'success'=>$data['success'],
                'message'=>$data['message']
            ],$data['status']);
        }
        return response()->json([
            'success'=>$data['success'],
            'message'=>$data['message'],
        ],$data['status']);
    }
    /**
     * RESET PASSWORD
     * @unauthenticated
     */
    public function reset_password(Resetpasswordrequest $request):JsonResponse
    {
        $data=$this->authService->reset_password(ResetDTO::fromRequest($request));
        if($data['success']){
            return response()->json([
                'success'=>$data['success'],
                'message'=>$data['message'],  
            ],$data['status']);
        }
        return response()->json([
            'message'=>$data['message'],
            'success'=>$data['success']
        ],$data['status']);
    }
}
