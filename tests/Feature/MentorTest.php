<?php

namespace Tests\Feature;

use App\Enum\Courses\CourseType;
use App\Enum\Users\GenderEnum;
use App\Enum\Users\RoleEnum;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MentorTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $this->admin = User::factory()->create([
            'role' => RoleEnum::ADMIN->value
        ]);
    }

    public function test_unauthorized_user_cannot_store_mentor(): void
    {
        $response = $this->post('/admin/mentor', []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_store_mentor(): void
    {
        $user = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $response = $this->actingAs($user)
            ->post('/admin/mentor', []);

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_admin_can_store_mentor(): void
    {
        $data = Mentor::factory()->create([
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 1024),
        ])->toArray();

        $response = $this->actingAs($this->admin)
            ->post('/admin/mentor', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/mentor');
    }

    public function test_bad_request_missing_field()
    {
        $data = [
            'name' => 'John Doe',
            'address' => 'Test Address 123',
            'desc' => 'Test Description',
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 1024),
            'portfolio' => 'https://portfolio.test',
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/mentor', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_bad_request_invalid_size_file()
    {
        $data = Mentor::factory()->create([
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 5000),
        ])->toArray();

        $response = $this->actingAs($this->admin)
            ->post('/admin/mentor', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_bad_request_invalid_file_type()
    {
        $data = Mentor::factory()->create([
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.gif', 1024),
        ])->toArray();

        $response = $this->actingAs($this->admin)
            ->post('/admin/mentor', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_admin_can_update_mentor(): void
    {
        $mentor = Mentor::factory()->create([
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 1024),
        ]);

        $data = [
            'name' => 'John Doe Updated',
            'address' => 'Test Address 123 Updated',
            'gender' => GenderEnum::MA->value,
            'desc' => 'Test Description',
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 1024),
            'portfolio' => 'https://portfolio.test',
            'field' => CourseType::ACADEMIC->value
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/mentor/{$mentor->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/mentor');
    }

    public function test_bad_request_invalid_file_type_update()
    {
        $mentor = Mentor::factory()->create([
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 1024),
        ]);

        $data = [
            'name' => 'John Doe Updated',
            'address' => 'Test Address 123 Updated',
            'gender' => GenderEnum::MA->value,
            'desc' => 'Test Description',
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.gif', 1024),
            'portfolio' => 'https://portfolio.test',
            'field' => CourseType::ACADEMIC->value
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/mentor/{$mentor->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_bad_request_invalid_file_size_update()
    {
        $mentor = Mentor::factory()->create([
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 1024),
        ]);

        $data = [
            'name' => 'John Doe Updated',
            'address' => 'Test Address 123 Updated',
            'gender' => GenderEnum::MA->value,
            'desc' => 'Test Description',
            'profile_picture' => UploadedFile::fake()->image('profile.jpg'),
            'cv' => UploadedFile::fake()->create('document.pdf', 5000),
            'portfolio' => 'https://portfolio.test',
            'field' => CourseType::ACADEMIC->value
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/mentor/{$mentor->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_admin_can_delete_mentor(): void
    {
        $mentor = Mentor::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete("/admin/mentor/{$mentor->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/admin/mentor');
    }
}
