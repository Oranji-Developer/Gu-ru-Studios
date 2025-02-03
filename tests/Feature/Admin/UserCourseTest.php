<?php

namespace Tests\Feature\Admin;

use App\Enum\Users\RoleEnum;
use App\Enum\Users\StatusEnum;
use App\Models\Children;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UserCourseTest extends TestCase
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

    public function test_admin_can_update_user_course_status(): void
    {
        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
        ]);

        $data = [
            'status' => StatusEnum::COMPLETED->value
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/invoice/{$userCourse->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/invoice');
        $response->assertSessionHas('success', 'Data berhasil diupdate!!');

        $this->assertDatabaseHas('user_courses', [
            'id' => $userCourse->id,
            'status' => StatusEnum::COMPLETED->value,
        ]);
    }

    public function test_non_admin_cannot_update_user_course_status(): void
    {
        $nonAdmin = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
        ]);

        $data = [
            'status' => StatusEnum::COMPLETED->value
        ];

        $response = $this->actingAs($nonAdmin)
            ->put("/admin/invoice/{$userCourse->id}", $data);

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_update_user_course_status_requires_valid_status(): void
    {
        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
        ]);

        $data = [
            'status' => 'invalid_status'
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/invoice/{$userCourse->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status']);
    }

    public function test_admin_can_update_user_course_status_multiple_fields(): void
    {
        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
        ]);

        $data = [
            'status' => StatusEnum::COMPLETED->value
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/invoice/{$userCourse->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/invoice');
        $response->assertSessionHas('success', 'Data berhasil diupdate!!');

        $this->assertDatabaseHas('user_courses', [
            'id' => $userCourse->id,
            'status' => StatusEnum::COMPLETED->value,
        ]);
    }

    public function test_user_course_observer_update_enrolled_course(): void
    {
        $course = Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id]);

        $userCourse = UserCourse::factory()->create([
            'course_id' => $course->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
            'status' => StatusEnum::UNPAID->value,
        ]);

        $userCourse2 = UserCourse::factory()->create([
            'course_id' => $course->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
            'status' => StatusEnum::UNPAID->value,
        ]);

        $userCourse->update(['status' => StatusEnum::PAID->value]);

        $course->refresh();

        $this->assertEquals(1, $course->enrolled);

        $userCourse2->update(['status' => StatusEnum::PAID->value]);

        $course->refresh();

        $this->assertEquals(2, $course->enrolled);
    }

    public function test_user_course_observer_update_decrement_enrolled_course()
    {
        $course = Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id]);

        $userCourse = UserCourse::factory()->create([
            'course_id' => $course->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
            'status' => StatusEnum::UNPAID->value,
        ]);

        $userCourse2 = UserCourse::factory()->create([
            'course_id' => $course->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
            'status' => StatusEnum::UNPAID->value,
        ]);

        $userCourse->update(['status' => StatusEnum::PAID->value]);
        $userCourse2->update(['status' => StatusEnum::PAID->value]);

        $course->refresh();

        $this->assertEquals(2, $course->enrolled);

        $userCourse2->update(['status' => StatusEnum::COMPLETED->value]);

        $course->refresh();

        $this->assertEquals(1, $course->enrolled);
    }
}
