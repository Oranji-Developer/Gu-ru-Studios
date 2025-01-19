<?php

namespace Tests\Feature;

use App\Models\Children;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\User;
use App\Models\UserCourse;
use App\Enum\Users\RoleEnum;
use App\Enum\Users\StatusEnum;
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

    public function test_user_course_observer_sets_status_to_completed(): void
    {
        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => Children::factory()->create(['user_id' => User::factory()->create()->id])->id,
            'end_date' => Carbon::now()->subDays(4)->toDateString(),
            'status' => StatusEnum::PAID->value,
        ]);

        $userCourse->refresh();

        $this->assertEquals(StatusEnum::COMPLETED->value, $userCourse->status);
    }

}
