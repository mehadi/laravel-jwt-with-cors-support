<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JwtAuthTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCannotSeeAProtectedRoute()
    {
        $response = $this->json('GET', 'api/me');        
        $response->assertStatus(401); //unauthorized status code
    }

    public function testGuestsCanRegister()
    {
        $response = $this->json('POST', 'api/register', [
            'name' => 'example',
            'email' => 'example@example.com',
            'password' => 'example',
            'password_confirmation' => 'example'
        ]);   



        $response->assertJsonStructure([
            'access_token', 'token_type', 'expires_in'
        ]);
        $response->assertStatus(200);
    }

    public function testIfNotRegisteredUserCanLogIn()
    {
        $user = User::factory()->make();
        
        $response = $this->json('POST', 'api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);   

        $response->assertJsonStructure([
            'error'
        ]);

        $response->assertStatus(401); //Unauthorized
    }

    public function testUsersCanLoggedIn()
    {
        $user = User::factory()->create();
        
        $response = $this->json('POST', 'api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);   

        $response->assertJsonStructure([
            'access_token', 'token_type', 'expires_in'
        ]);
        $response->assertStatus(200);
    }
}
