<?php

namespace Tests\Feature\Admin;

use App\Enum\Courses\AcademicClass;
use App\Enum\Courses\CourseType;
use App\Enum\Users\RoleEnum;
use App\Enum\Courses\StatusEnum;
use App\Models\Course;
use App\Models\Event;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => RoleEnum::ADMIN->value
        ]);
    }

    public function test_admin_can_store_event(): void
    {
        $data = [
            'title' => 'Test Event',
            'thumbnail' => UploadedFile::fake()->image('event.jpg'),
            'desc' => 'Test Description',
            'disc' => 99.99,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'start_date' => '2025-03-01',
            'end_date' => '2025-03-31',
            'status' => StatusEnum::ACTIVE->value,
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/event', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/event');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'desc' => 'Test Description',
            'disc' => 99.99,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'status' => StatusEnum::ACTIVE->value,
        ]);
    }

    public function test_non_admin_cannot_store_event(): void
    {
        $nonAdmin = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $data = [
            'title' => 'Test Event',
            'thumbnail' => UploadedFile::fake()->image('event.jpg'),
            'desc' => 'Test Description',
            'disc' => 99.99,
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'start_date' => '2025-03-01',
            'end_date' => '2025-03-31',
            'status' => StatusEnum::ACTIVE->value,
        ];

        $response = $this->actingAs($nonAdmin)
            ->post('/admin/event', $data);

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_store_event_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/event', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title', 'thumbnail', 'desc', 'disc', 'course_type', 'class', 'start_date', 'end_date', 'status']);
    }

    public function test_admin_can_update_event_status(): void
    {
        $event = Event::factory()->create();

        $data = [
            'status' => StatusEnum::ACTIVE->value
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/event/{$event->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/event');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'status' => StatusEnum::ACTIVE->value,
        ]);
    }

    public function test_non_admin_cannot_update_event_status(): void
    {
        $nonAdmin = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $event = Event::factory()->create();

        $data = [
            'status' => StatusEnum::ACTIVE->value
        ];

        $response = $this->actingAs($nonAdmin)
            ->put("/admin/event/{$event->id}", $data);

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_update_event_validates_status(): void
    {
        $event = Event::factory()->create();

        $data = [
            'status' => 'invalid_status'
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/event/{$event->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status']);
    }

    public function test_observer_resets_course_discounts_when_event_status_changes(): void
    {
        $mentor = Mentor::factory()->create();

        $course = Course::factory()->create([
            'class' => AcademicClass::CLASS1->value,
            'disc' => 50.00,
            'course_type' => CourseType::ACADEMIC->value,
            'mentor_id' => $mentor->id
        ]);

        $event = Event::factory()->create([
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'disc' => 50.00,
            'status' => StatusEnum::ACTIVE->value
        ]);

        $event->update([
            'status' => StatusEnum::INACTIVE->value
        ]);

        $event->refresh();
        $course->refresh();

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'disc' => 0
        ]);
    }

    public function test_observer_updates_course_discounts_when_event_discount_changes(): void
    {
        $mentor = Mentor::factory()->create();

        $course = Course::factory()->create([
            'class' => AcademicClass::CLASS1->value,
            'disc' => 50.00,
            'course_type' => CourseType::ACADEMIC->value,
            'mentor_id' => $mentor->id
        ]);

        $event = Event::factory()->create([
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'disc' => 50.00,
            'status' => StatusEnum::ACTIVE->value
        ]);

        $event->update([
            'disc' => 75.00
        ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'disc' => 75.00
        ]);
    }

    public function test_observer_updates_course_discounts_when_event_class_changes(): void
    {
        $mentor = Mentor::factory()->create();

        $class1Course = Course::factory()->create([
            'class' => AcademicClass::CLASS1->value,
            'disc' => 50.00,
            'course_type' => CourseType::ACADEMIC->value,
            'mentor_id' => $mentor->id
        ]);

        $class2Course = Course::factory()->create([
            'class' => AcademicClass::CLASS2->value,
            'disc' => 0,
            'course_type' => CourseType::ACADEMIC->value,
            'mentor_id' => $mentor->id
        ]);

        $event = Event::factory()->create([
            'course_type' => CourseType::ACADEMIC->value,
            'class' => AcademicClass::CLASS1->value,
            'disc' => 50.00,
            'status' => StatusEnum::ACTIVE->value
        ]);

        $event->update([
            'class' => AcademicClass::CLASS2->value
        ]);

        $this->assertDatabaseHas('courses', [
            'id' => $class1Course->id,
            'disc' => 50.00
        ]);

        $this->assertDatabaseHas('courses', [
            'id' => $class2Course->id,
            'disc' => 50.00
        ]);
    }
}
