<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CentralAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_on_central_domain()
    {
        $response = $this->postJson('/central/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email', 'username'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'username' => 'johndoe',
        ]);
    }

    /** @test */
    public function user_can_login_on_central_domain()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/central/login', [
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'user',
            ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/central/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials',
            ]);

        $this->assertGuest();
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/central/logout');

        $response->assertStatus(200);
        $this->assertGuest();
    }

    /** @test */
    public function authenticated_user_can_get_their_info()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'customer',
        ]);

        $response = $this->actingAs($user)
            ->getJson('/central/me');

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'role' => 'customer',
                ]
            ]);
    }

    /** @test */
    public function guest_cannot_access_protected_routes()
    {
        $response = $this->getJson('/central/me');

        $response->assertStatus(401);
    }

    /** @test */
    public function it_validates_required_registration_fields()
    {
        $response = $this->postJson('/central/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function it_validates_password_confirmation()
    {
        $response = $this->postJson('/central/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_validates_unique_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->postJson('/central/register', [
            'name' => 'John Doe',
            'email' => 'existing@example.com',
            'username' => 'johndoe',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_validates_unique_username()
    {
        User::factory()->create(['username' => 'existinguser']);

        $response = $this->postJson('/central/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'existinguser',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['username']);
    }

    /** @test */
    public function newly_registered_users_have_customer_role_by_default()
    {
        $this->postJson('/central/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        
        $this->assertEquals('customer', $user->role);
    }

    /** @test */
    public function user_cannot_login_without_email()
    {
        $response = $this->postJson('/central/login', [
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function user_cannot_login_without_password()
    {
        $response = $this->postJson('/central/login', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
}
