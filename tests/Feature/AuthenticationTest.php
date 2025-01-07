<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    // Login

    // public function test_login_page_is_displayed(): void
    // {
    //     $response = $this->get('/login');

    //     $response->assertOk();
    // }

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

    //Register

    // public function test_register_page_is_displayed(): void
    // {
    //     $response = $this->get('/register');

    //     $response->assertOk();
    // }

    public function test_users_can_register_with_valid_data(): void
    {

        $user = User::factory()->create([
            'nama' => 'Odare',
            'email' => 'noun@example.org',
            'password' => bcrypt('password')
        ]);

        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(200);
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

    // Forgot-password

    // public function test_forgot_password_page_is_displayed(): void
    // {
    //     $response = $this->get('/forgot-password');

    //     $response->assertOk();
    // }

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

    public function valid_token_allows_access_to_reset_password_page()
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

    public function invalid_token_shows_error_or_redirects()
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
        ]);

        $invalidToken = 'invalid-reset-token';

        $response = $this->get("/reset-password/{$invalidToken}", [
            'email' => $user->email,
        ]);

        $response->assertStatus(200); // Sesuaikan dengan logika kontroler
        $response->assertSee('Reset Password');
    }

    public function accessing_reset_password_without_token_returns_error()
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
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/reset-password', [
            'email' => $user->email,
            'password' => $user->password,
            'token' => 'valid-token',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
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
    }

    // oauth google



    //verify-email
    // generate
    // public function authenticated_user_can_access_email_verification_prompt()
    // {
    //     $user = User::factory()->create([
    //         'email_verified_at' => null,
    //     ]);

    //     $this->actingAs($user);

    //     $response = $this->get('/verify-email');

    //     $response->assertStatus(200);
    //     $response->assertSee('Verify Your Email'); // Ganti sesuai teks halaman
    // }

    // public function email_can_be_verified_with_valid_id_and_hash()
    // {
    //     $user = User::factory()->create([
    //         'email_verified_at' => null,
    //     ]);

    //     $this->actingAs($user);

    //     $hash = sha1($user->email);

    //     $response = $this->get("/verify-email/{$user->id}/{$hash}");

    //     $response->assertRedirect('/');
    //     $this->assertNotNull($user->fresh()->email_verified_at);
    // }

    // public function authenticated_user_can_request_verification_email()
    // {
    //     $user = User::factory()->create([
    //         'email_verified_at' => null,
    //     ]);

    //     $this->actingAs($user);

    //     $response = $this->post('/email/verification-notification');

    //     $response->assertStatus(200);
    //     $response->assertJson(['message' => 'Verification link sent!']);
    // }

    // //Comfirm-password
    // public function authenticated_user_can_access_password_confirmation_page()
    // {

    //     $response = $this->get('/confirm-password');

    //     $response->assertStatus(200);
    //     $response->assertSee('Confirm Password'); // Ganti sesuai teks halaman
    // }

    // public function authenticated_user_can_confirm_password_with_valid_data()
    // {
    //     $user = User::factory()->create([
    //         'email' => 'odare@exampl.org',
    //         'password' => bcrypt('password123'),
    //     ]);

    //     $this->actingAs($user);

    //     $response = $this->post('/confirm-password', [
    //         'email' => $user->email,
    //         'password' => $user->password,
    //     ]);

    //     $response->assertRedirect(); // Sesuaikan dengan logika aplikasi
    // }

    // public function authenticated_user_can_update_password()
    // {
    //     $user = User::factory()->create([
    //         'password' => bcrypt('oldpassword'),
    //     ]);

    //     $this->actingAs($user);

    //     $response = $this->put('/password', [
    //         'current_password' => 'oldpassword',
    //         'password' => 'newpassword123',
    //     ]);

    //     $response->assertRedirect('/');
    //     $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    // }

    // public function authenticated_user_can_logout()
    // {
    //     $user = User::factory()->create();

    //     $this->actingAs($user);

    //     $response = $this->post('/logout');

    //     $response->assertRedirect('/');
    //     $this->assertGuest();
    // }



}

