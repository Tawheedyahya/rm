<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    
    public function test_user_can_login_with_correct_credentials(){
        Role::create([
            'name'=>'super_admin'
        ]);
        $user=User::factory()->create([
            'email'=>'tawheedyahya0@gmail.com',
            'password'=>Hash::make('yahiyahi'),
            'role_id'=>1
        ]);
        $response=$this->post('/api/login',[
            'email'=>'tawheedyahya0@gmail.com',
            'password'=>'yahiyahi'
        ]);
        $response->assertStatus(200)
         ->assertJsonStructure([
             'success',
             'status',
             'access_token',
             'token_type',
             'expires_in',
             'refresh_token',
             'user' => [
                 'id',
                 'name',
                 'email',
                 'role_id',
                 'role' => [
                     'id',
                     'name'
                 ]
             ]
         ]);
    }
    public function test_user_can_login_with_wrong_crediantials(){
        $response=$this->post('/api/login',[
            'email'=>'tawheedyahya@gmail.com',
            'password'=>'djahsjkd'
        ]);
        $response->assertStatus(401)->assertJsonStructure([
            'message'
        ]);
        $response=$this->post('/api/login');
        $response->assertStatus(422);
        $response=$this->post('/api/login',[
            'email'=>'tawheedyahya0@gmail.com',
            'password'=>''
        ]);
        $response->assertStatus(422);
    }
    /**
     * Access protected route with token
     */
    public function test_user_can_access_protected_route_with_token()
    {
        $role = Role::create(['name' => 'super_admin']);

        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'role_id' => $role->id
        ]);

        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $token = $login['access_token'];

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->get('/api/profile'); 

        $response->assertStatus(200);
    }
    /**
     * Validation errors
     */
    public function test_login_requires_email_and_password()
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * Empty password
     */
    public function test_login_fails_with_empty_password()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => ''
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }
    /**
     * ROLE CHECK
     */
    public function test_user_with_wrong_role_cannot_access_super_admin_route()
{
    $role = \App\Models\Role::create([
        'name' => 'user'
    ]);

    $user = \App\Models\User::factory()->create([
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role_id' => $role->id
    ]);

    $login = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password'
    ]);

    $token = $login['access_token'];

    $response = $this->withHeader('Authorization', "Bearer $token")
                     ->getJson('/api/super_admin/hotel_lists');

    $response->assertStatus(403);
}
public function test_super_admin_can_access_route()
{
    $role = \App\Models\Role::create([
        'name' => 'super_admin'
    ]);

    $user = \App\Models\User::factory()->create([
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role_id' => $role->id
    ]);

    $login = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password'
    ]);

    $token = $login['access_token'];

    $response = $this->withHeader('Authorization', "Bearer $token")
                     ->getJson('/api/super_admin/hotel_lists');

    $response->assertStatus(200);
}
public function test_refresh_token_rotation()
{
    // create role
    $role = \App\Models\Role::create([
        'name' => 'super_admin'
    ]);

    // create user
    $user = \App\Models\User::factory()->create([
        'email' => 'tawheedyahya0@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role_id' => $role->id
    ]);

    // 🔐 Step 1: Login
    $login = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password'
    ]);

    $login->assertStatus(200)
        ->assertJsonStructure([
            'access_token',
            'refresh_token'
        ]);

    $refreshToken1 = $login['refresh_token'];

    // 🔁 Step 2: First refresh (valid rotation)
    $refreshResponse = $this->postJson('/api/token/refresh', [
        'refresh_token' => $refreshToken1
    ]);

    $refreshResponse->assertStatus(200)
        ->assertJsonStructure([
            'access_token',
            'refresh_token'
        ]);

    $refreshToken2 = $refreshResponse['refresh_token'];

    // ❌ Step 3: Try OLD refresh token again → must fail
    $oldTokenResponse = $this->postJson('/api/token/refresh', [
        'refresh_token' => $refreshToken1
    ]);

    $oldTokenResponse->assertStatus(401)
        ->assertJson([
            'message' => 'Refresh token revoked'
        ]);

    // ✅ Step 4: Use NEW refresh token → must succeed
    $newTokenResponse = $this->postJson('/api/token/refresh', [
        'refresh_token' => $refreshToken2
    ]);

    $newTokenResponse->assertStatus(200)
        ->assertJsonStructure([
            'access_token',
            'refresh_token'
        ]);
}
}
