<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_users_can_not_login_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    // Start sliwik disini

    public function test_users_can_not_login_with_invalid_email(): void
    {
        $user = User::factory()->create([
            'email' => 'noun@example.org',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'email' => 'wrong-password',
            'password' => $user->password,
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_users_can_not_login_with_invalid_email_and_password(): void
    {
        $user = User::factory()->create([
            'email' => 'noun@example.org',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/login', [
            'email' => 'wrong-password',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();

    }

    public function test_users_can_register_with_valid_data(): void
    {
        $user = [
            'name' => 'Odare',
            'email' => 'odare@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->post('/register', $user);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }

    public function test_users_can_not_register_with_invalid_email(): void
    {

        $response = $this->post('/register', [
            'name' => 'Odare',
            'email' => 'odareexample.org',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_users_can_not_register_with_invalid_password(): void
    {

        $response = $this->post('/register', [
            'name' => 'Odare',
            'email' => 'odare@example.org',
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_users_can_request_reset_password(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertStatus(302);
    }

    public function test_users_can_not_request_reset_password_with_invalid_email(): void
    {
        $user = User::factory()->create([
            'email' => 'odareexample.org',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertSessionHasErrors();
    }

    // Reset-password

    public function valid_token_allows_access_to_reset_password_page(): void
    {

        $user = User::factory()->create([
            'email' => 'odare@example.org',
        ]);

        $token = 'valid-reset-token';

        $response = $this->get("/reset-password/{$token}", [
            'email' => $user->email,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Reset Password');
    }

    public function invalid_token_shows_error_or_redirects(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
        ]);

        $invalidToken = 'invalid-reset-token';

        $response = $this->get("/reset-password/{$invalidToken}", [
            'email' => $user->email,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Reset Password');
    }

    public function accessing_reset_password_without_token_returns_error(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
        ]);

        $response = $this->get('/reset-password/', [
            'email' => $user->email,
        ]);

        $response->assertStatus(404);
    }

    public function test_users_can_reset_password_with_valid_data(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@gmail.com',
            'password' => bcrypt('oldpassword'),
        ]);

        $token = Password::createToken($user);

        $newPassword = 'newpassword';

        $response = $this->post('/reset-password', [
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'token' => $token,
        ]);

        $response->assertStatus(302);

        $this->assertTrue(Auth::attempt([
            'email' => $user->email,
            'password' => $newPassword,
        ]), 'Pengguna gagal login dengan password baru.');
    }

    public function test_users_can_not_reset_password_with_invalid_data(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/reset-password', [
            'email' => $user->email,
            'password' => $user->password,
            'token' => 'invalid-token',
        ]);

        $response->assertSessionHasErrors();
    }
}

