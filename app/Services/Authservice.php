<?php

namespace App\Services;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\DTOs\ResetDTO;
use App\Mail\Resetpasswordmail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Octane\Facades\Octane;

use Tymon\JWTAuth\Facades\JWTAuth;

class Authservice
{
    // ================= LOGIN =================
    public function login(LoginDTO $dto): array
    {
        $credentials = [
            'email'    => $dto->email,
            'password' => $dto->password,
        ];

        // ✅ attempt() = bcrypt + ACCESS TOKEN (ONCE)
        $accessToken = auth('api')
            ->claims(['type' => 'access'])
            ->attempt($credentials);

        if (! $accessToken) {
            return [
                'success' => false,
                'status'  => 401,
                'message' => 'Invalid email or password',
            ];
        }

        // user already authenticated by attempt()
        $user = auth('api')->user();

        // ✅ create REFRESH token only
        $refreshToken = auth('api')
            ->claims(['type' => 'refresh'])
            ->setTTL(config('jwt.refresh_ttl'))
            ->login($user);

        // store refresh token
        $this->storeRefreshToken($user->id, $refreshToken);

        return [
            'success'       => true,
            'status'        => 200,
            'access_token'  => $accessToken,
            'token_type'    => 'Bearer',
            'expires_in'    => auth('api')->factory()->getTTL() * 60,
            'refresh_token' => $refreshToken,
            'user'          => $user,
        ];
    }

    // ================= REGISTER =================
    public function register(RegisterDTO $dto): array
    {
        if (User::where('email', $dto->email)->exists()) {
            return [
                'success' => false,
                'status'  => 409,
                'message' => 'Email already exists',
            ];
        }

        $user = User::create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => bcrypt($dto->password),
        ]);

        $accessToken = auth('api')
            ->claims(['type' => 'access'])
            ->login($user);

        $refreshToken = auth('api')
            ->claims(['type' => 'refresh'])
            ->setTTL(config('jwt.refresh_ttl'))
            ->login($user);

        $this->storeRefreshToken($user->id, $refreshToken);

        return [
            'success'       => true,
            'status'        => 201,
            'access_token'  => $accessToken,
            'token_type'    => 'Bearer',
            'expires_in'    => auth('api')->factory()->getTTL() * 60,
            'refresh_token' => $refreshToken,
            'user'          => $user,
        ];
    }

    // ================= REFRESH =================
    public function refresh(string $refreshToken): array
    {
        try {
            $payload = JWTAuth::setToken($refreshToken)->payload();

            if (($payload['type'] ?? null) !== 'refresh') {
                return [
                    'success' => false,
                    'status'  => 401,
                    'message' => 'Invalid refresh token',
                ];
            }

            $user = auth('api')->setToken($refreshToken)->authenticate();

            if (! $user || ! $this->isRefreshTokenValid($user->id, $refreshToken)) {
                return [
                    'success' => false,
                    'status'  => 401,
                    'message' => 'Refresh token revoked',
                ];
            }

            // rotation
            $this->revokeRefreshToken($user->id, $refreshToken);
            JWTAuth::setToken($refreshToken)->invalidate(true);

            $newAccessToken = auth('api')
                ->claims(['type' => 'access'])
                ->login($user);

            $newRefreshToken = auth('api')
                ->claims(['type' => 'refresh'])
                ->setTTL(config('jwt.refresh_ttl'))
                ->login($user);

            $this->storeRefreshToken($user->id, $newRefreshToken);

            return [
                'success'       => true,
                'status'        => 200,
                'access_token'  => $newAccessToken,
                'token_type'    => 'Bearer',
                'expires_in'    => auth('api')->factory()->getTTL() * 60,
                'refresh_token' => $newRefreshToken,
                'user'          => $user,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'status'  => 401,
                'message' => 'Invalid or expired refresh token',
            ];
        }
    }

    // ================= REDIS HELPERS =================

    private function storeRefreshToken(int $userId, string $refreshToken): void
    {
        $jti = JWTAuth::setToken($refreshToken)->payload()->get('jti');
        Cache::put(
            "refresh_token:user:$userId:$jti",
            true,
            now()->addMinutes(config('jwt.refresh_ttl'))
        );
    }

    private function isRefreshTokenValid(int $userId, string $refreshToken): bool
    {
        $jti = JWTAuth::setToken($refreshToken)->payload()->get('jti');
        return Cache::has("refresh_token:user:$userId:$jti");
    }

    private function revokeRefreshToken(int $userId, string $refreshToken): void
    {
        $jti = JWTAuth::setToken($refreshToken)->payload()->get('jti');
        Cache::forget("refresh_token:user:$userId:$jti");
    }
    public function logout(string $refresh_token){
        try{
            if($refresh_token){
                $payload=JWTAuth::setToken($refresh_token)->payload();
                if(($payload['type']??null)==='refresh'){
                    $user=auth('api')->setToken($refresh_token)->authenticate();
                    if($user){
                        $this->revokeRefreshToken($user->id,$refresh_token);
                    }
                    JWTAuth::setToken($refresh_token)->invalidate(true);
                }
            }
            if($access_token=request()->bearerToken()){
                JWTAuth::setToken($access_token)->invalidate(true);
            }
        }catch(\Throwable $e){

        }
    }
    public function password_change(string $email)
    {
        $user=User::where('email',$email)->first();
        if(!$user){
            return $this->error('User not found',404);
        }
        $token=Str::random(60);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email'=>$email],
            [
                'token'=>Hash::make($token),
                // 'token'=>$token,
                'created_at'=>Carbon::now()
            ]
        );
        $url=config('app.request_url').'/reset_password?token='.$token.'&email='.$email;
        Mail::to($email)->queue(new Resetpasswordmail($url));
        return [
            'success'=>true,
            'status'=>200,
            'message'=>'Password resent link send to email',
            'token'=>$token,
        ];
    }
    protected function error(string $message,int $status){
        return [
            'message'=>$message,
            'status'=>$status,
            'success'=>false
        ];
    }

    public function reset_password(ResetDTO $dto): array
    {
        [$record, $user] = Octane::concurrently([
            fn () => DB::table('password_reset_tokens')
                ->where('email', $dto->email)
                ->first(),

            fn () => User::where('email', $dto->email)->first(),
        ]);

        if (!$record) {
            return $this->error('User not found', 404);
        }

        if (!Hash::check($dto->token,$record->token)) {
            return $this->error('Token is invalid', 401);
        }

        if (!$user) {
            return $this->error('User not found', 404);
        }

        // Update password safely
        $user->update([
            'password' => Hash::make($dto->password)
        ]);

        // Delete used token (important!)
        DB::table('password_reset_tokens')
            ->where('email', $dto->email)
            ->delete();

        return [
            'message' => 'Password reset successfully',
            'status'  => 200,
            'success' => true
        ];
    }
}
