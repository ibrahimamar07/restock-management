<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Login bro', false);
    }

    public function test_authenticated_user_can_access_protected_routes()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }
}
