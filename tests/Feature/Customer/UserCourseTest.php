<?php

namespace Tests\Feature\Customer;

use App\Enum\Users\RoleEnum;
use App\Enum\Users\StatusEnum;
use App\Models\Children;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCourseTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;
    private User $nonCustomer;
    private Children $children;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $this->nonCustomer = User::factory()->create([
            'role' => RoleEnum::ADMIN->value
        ]);

        $this->children = Children::factory()->create([
            'user_id' => $this->customer->id
        ]);
    }

    public function test_customer_can_store_user_course(): void
    {
        $course = Course::factory()->create([
            'mentor_id' => Mentor::factory()->create()->id
        ]);

        $data = [
            'course_id' => $course->id,
            'children_id' => $this->children->id,
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/course', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/user/course');
        $response->assertSessionHas('success', 'Data berhasil disimpan!!');

        $this->assertDatabaseHas('user_courses', [
            'course_id' => $course->id,
            'children_id' => $this->children->id,
            'status' => StatusEnum::UNPAID->value
        ]);
    }

    public function test_customer_cannot_store_user_course_with_invalid_data(): void
    {
        $data = [
            'course_id' => 999,
            'children_id' => 999,
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/course', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['course_id', 'children_id']);
    }

    public function test_customer_cannot_access_edit_page_of_unowned_course(): void
    {
        $otherChildren = Children::factory()->create([
            'user_id' => User::factory()->create()->id
        ]);

        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => $otherChildren->id,
        ]);

        $response = $this->actingAs($this->customer)
            ->get("/user/course/{$userCourse->id}/edit");

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Anda tidak memiliki akses!!');
    }

    public function test_customer_can_update_owned_course(): void
    {
        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => $this->children->id,
        ]);

        $data = [
            'status' => StatusEnum::COMPLETED->value
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/course/{$userCourse->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/user/course');
        $response->assertSessionHas('success', 'Data berhasil diupdate!!');

        $this->assertDatabaseHas('user_courses', [
            'id' => $userCourse->id,
            'status' => StatusEnum::COMPLETED->value,
        ]);
    }

    public function test_customer_cannot_update_unowned_course(): void
    {
        $otherChildren = Children::factory()->create([
            'user_id' => User::factory()->create()->id
        ]);

        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => $otherChildren->id,
        ]);

        $data = [
            'status' => StatusEnum::COMPLETED->value
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/course/{$userCourse->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Anda tidak memiliki akses!!');
    }

    public function test_customer_cannot_update_with_invalid_status(): void
    {
        $userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => $this->children->id,
        ]);

        $data = [
            'status' => 'invalid_status'
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/course/{$userCourse->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status']);
    }
}
