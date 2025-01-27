<?php

namespace Tests\Feature\Admin;

use App\Enum\Users\RoleEnum;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\AcademicClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Validation\Rule;


class EventTest extends TestCase
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

    public function test_unauthorized_user_cannot_store_Event(): void
    {
        $response = $this->post('/admin/event', []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_non_admin_user_cannot_store_Event(): void
    {
        $user = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $response = $this->actingAs($user)->post('/admin/event', []);

        $response->assertStatus(403);
    }

    public function test_admin_can_store_Event(): void
    {
        $data = [
            'title' => 'Event Name',
            'desc' => 'Event Description',
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'disc' => 1000,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-01',
        ];
        $response = $this->actingAs($this->admin)
            ->post('/admin/event', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/event');
    }

    public function test_unauthorized_user_cannot_update_Event(): void
    {
        $event = Event::factory()->create();

        $response = $this->put("/admin/event/{$event->id}", []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_non_admin_user_cannot_update_Event(): void
    {
        $user = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);
        $event = Event::factory()->create();

        $response = $this->actingAs($user)->put("/admin/event/{$event->id}", []);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_Event(): void
    {
        $event = Event::factory()->create();
        $data = [
            'name' => 'Event Name',
            'description' => 'Event Description',
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg')
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/event/{$event->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/event');
    }
}
