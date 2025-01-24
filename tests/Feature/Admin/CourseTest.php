<?php

namespace Tests\Feature\Admin;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Enum\Users\RoleEnum;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourseTest extends TestCase
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

    public function test_unauthorized_user_cannot_store_course(): void
    {
        $response = $this->post('/admin/course', []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_store_course(): void
    {
        $user = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $response = $this->actingAs($user)
            ->post('/admin/course', []);

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_admin_can_store_course(): void
    {
        $mentor = Mentor::factory()->create();

        $data = [
            'mentor_id' => $mentor->id,
            'title' => 'Test Course',
            'desc' => 'Test Description',
            'capacity' => 20,
            'cost' => 100000,
            'disc' => 10,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'status' => StatusEnum::ACTIVE->value,
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(30)->format('Y-m-d'),
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:00',
            'total_meet' => 12
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/course', $data);

        $response->assertStatus(302);
        if($response->exception) {
            dump($response->exception->getMessage());
            dump(session('errors')->getBag('default')->all());
        }
        $response->assertRedirect('/admin/course');
    }

    public function test_bad_request_missing_field(): void
    {
        $data = [
            'title' => 'Test Course',
            'desc' => 'Test Description',
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/course', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_bad_request_invalid_file(): void
    {
        $mentor = Mentor::factory()->create();

        $data = [
            'mentor_id' => $mentor->id,
            'title' => 'Test Course',
            'desc' => 'Test Description',
            'capacity' => 20,
            'cost' => 100000,
            'disc' => 10,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'thumbnail' => UploadedFile::fake()->create('document.pdf'),
            'status' => StatusEnum::ACTIVE->value,
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(30)->format('Y-m-d'),
            'day' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:00',
            'total_meet' => 12
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/course', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_admin_can_update_course(): void
    {
        $course = Course::factory()->create([
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'mentor_id' => Mentor::factory()->create()->id
        ]);

        $data = [
            'mentor_id' => $course->mentor_id,
            'title' => 'Updated Course',
            'desc' => 'Updated Description',
            'capacity' => 25,
            'cost' => 150000,
            'disc' => 15,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'thumbnail' => UploadedFile::fake()->image('new_thumbnail.jpg'),
            'status' => StatusEnum::ACTIVE->value,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(31)->format('Y-m-d'),
            'day' => 'Tuesday',
            'start_time' => '10:00',
            'end_time' => '11:00',
            'total_meet' => 15
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/course/{$course->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/course');
    }

    public function test_bad_request_invalid_file_type_update(): void
    {
        $course = Course::factory()->create([
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'mentor_id' => Mentor::factory()->create()->id
        ]);

        $data = [
            'mentor_id' => $course->mentor_id,
            'title' => 'Updated Course',
            'desc' => 'Updated Description',
            'capacity' => 25,
            'cost' => 150000,
            'disc' => 15,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'thumbnail' => UploadedFile::fake()->create('document.pdf'),
            'status' => StatusEnum::ACTIVE->value,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(31)->format('Y-m-d'),
            'day' => 'Tuesday',
            'start_time' => '10:00',
            'end_time' => '11:00',
            'total_meet' => 15
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/course/{$course->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }
}
