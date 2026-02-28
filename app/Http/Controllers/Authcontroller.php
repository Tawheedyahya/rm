<?php

namespace App\Http\Controllers;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\DTOs\ResetDTO;
use App\Http\Requests\Loginrequest;
use App\Http\Requests\Registerrequest;
use App\Http\Requests\Resetpasswordrequest;
use App\Services\Authservice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Authcontroller extends Controller
{
    public function __construct(private Authservice $authService) {}

    public function login(Loginrequest $request): JsonResponse
    {
        $data = $this->authService->login(LoginDTO::fromRequest($request));

        if (! $data['success']) {
            return response()->json([
                'message' => $data['message']
            ], $data['status']);
        }

        return response()->json($data, $data['status'])
            ->cookie('refresh_token', $data['refresh_token'], 43200, '/', null, true, true);
    }
    public function register(Registerrequest $request):JsonResponse
    {
        $data = $this->authService->register(RegisterDTO::fromRequest($request));

        if (! $data['success']) {
            return response()->json([
                'message' => $data['message']
            ], $data['status']);
        }

        return response()->json($data, $data['status'])
            ->cookie('refresh_token', $data['refresh_token'], 43200, null, null, true, true);
    }

    public function refresh(Request $request): JsonResponse
    {
        $refreshToken = $request->input('refresh_token')
            ?? $request->header('X-Refresh-Token')
            ?? $request->cookie('refresh_token');

        if (! $refreshToken) {
            return response()->json([
                'message' => 'No refresh token provided'
            ], 401);
        }

        $data = $this->authService->refresh($refreshToken);

        if (! $data['success']) {
            return response()->json([
                'message' => $data['message']
            ], $data['status']);
        }

        return response()->json($data, $data['status'])
            ->cookie('refresh_token', $data['refresh_token'], 43200, null, null, true, true);
    }

    public function profile(): JsonResponse
    {
        return response()->json([
            'user' => auth('api')->user(),
        ]);
    }

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
    public function password_change(Request $request){
        $request->validate([
            'email'=>'required|string|email'
        ]);
        $data=$this->authService->password_change($request->email);
        if(!$data['success']){
            return response()->json([
                'message'=>$data['message']
            ],$data['status']);
        }
        return response()->json([
            'message'=>$data['message'],
        ],$data['status']);
    }
    public function reset_password(Resetpasswordrequest $request):JsonResponse
    {
        $data=$this->authService->reset_password(ResetDTO::fromRequest($request));
        if($data['success']){
            return response()->json([
                'message'=>$data['message'],
                'status'=>$data['status'],
            ]);
        }
        return response()->json([
            'message'=>$data['message'],
            'status'=>$data['status']
        ]);
    }
}
