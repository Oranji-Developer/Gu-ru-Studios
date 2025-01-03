<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JsonException;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard/profile');

        $response->assertOk();
    }

    /**
     * @throws JsonException
     */
    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)
            ->patch('/dashboard/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'address' => 'Test Address 123'
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $user->refresh();

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('1234567890', $user->phone);
        $this->assertEquals('Test Address 123', $user->address);
    }

    /**
     * @throws JsonException
     */
    public function test_email_verification_status_is_unchanged_when_email_is_unchanged(): void
    {
        $user = User::factory()->create([
            'email' => 'odare@example.org',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($user)
            ->patch('/dashboard/profile', [
                'name' => 'Test User',
                'email' => 'odare@example.org',
                'phone' => '1234567890',
                'address' => 'Test Address 123'
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_cannot_update_profile_with_existing_email(): void
    {
        $userA = User::factory()->create([
            'email' => 'odare@example.org',
            'password' => bcrypt('password')
        ]);

        $userB = User::factory()->create([
            'email' => 'existing@example.com'
        ]);

        $response = $this->actingAs($userA)
            ->patch('/dashboard/profile', [
                'name' => 'Test User',
                'email' => 'existing@example.com',
                'phone' => '1234567890',
                'address' => 'Test Address 123'
            ]);

        $response->assertSessionHasErrors(['email']);
    }
}
