<?php

namespace Tests\Feature\Customer;

use App\Enum\Users\RatingEnum;
use App\Enum\Users\RoleEnum;
use App\Models\Children;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\Testimonies;
use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TestimonyTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;
    private User $nonCustomer;
    private UserCourse $userCourse;
    private Testimonies $testimony;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $this->nonCustomer = User::factory()->create([
            'role' => RoleEnum::ADMIN->value
        ]);

        $children = Children::factory()->create([
            'user_id' => $this->customer->id
        ]);

        $this->userCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => $children->id
        ]);

        $this->testimony = Testimonies::factory()->create([
            'userCourse_id' => $this->userCourse->id,
        ]);
    }

    public function test_customer_can_store_testimony(): void
    {
        $data = [
            'userCourse_id' => $this->userCourse->id,
            'desc' => 'Test testimony description',
            'rating' => RatingEnum::FIVE->value
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/testimony', $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Testimony berhasil dibuat!!');

        $this->assertDatabaseHas('testimonies', [
            'userCourse_id' => $this->userCourse->id,
            'desc' => 'Test testimony description',
            'rating' => RatingEnum::FIVE->value
        ]);
    }

    public function test_customer_cannot_store_testimony_with_invalid_data(): void
    {
        $data = [
            'userCourse_id' => 999,
            'desc' => str_repeat('a', 501),
            'rating' => 'invalid_rating'
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/testimony', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['userCourse_id', 'desc', 'rating']);
    }

    public function test_customer_can_update_own_testimony(): void
    {
        $data = [
            'desc' => 'Updated testimony description',
            'rating' => RatingEnum::FOUR->value
        ];

        $response = $this->actingAs($this->customer)
            ->patch("/user/testimony/{$this->testimony->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Testimony berhasil diupdate!!');

        $this->assertDatabaseHas('testimonies', [
            'id' => $this->testimony->id,
            'desc' => 'Updated testimony description',
            'rating' => RatingEnum::FOUR->value
        ]);
    }

    public function test_customer_cannot_update_testimony_with_invalid_data(): void
    {
        $data = [
            'desc' => str_repeat('a', 501),
            'rating' => 'invalid_rating'
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/testimony/{$this->testimony->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['desc', 'rating']);
    }

    public function test_customer_cannot_update_others_testimony(): void
    {
        $otherCustomer = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $otherChildren = Children::factory()->create([
            'user_id' => $otherCustomer->id
        ]);

        $otherUserCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => $otherChildren->id
        ]);

        $otherTestimony = Testimonies::factory()->create([
            'userCourse_id' => $otherUserCourse->id
        ]);

        $data = [
            'desc' => 'Updated testimony description',
            'rating' => RatingEnum::FOUR->value
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/testimony/{$otherTestimony->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Kamu tidak memiliki akses untuk mengupdate data ini.');
    }

    public function test_customer_can_delete_own_testimony(): void
    {
        $response = $this->actingAs($this->customer)
            ->delete("/user/testimony/{$this->testimony->id}");

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Testimony berhasil dihapus!!');

        $this->assertDatabaseHas('testimonies', [
            'id' => $this->testimony->id,
        ]);

        $this->assertDatabaseMissing('testimonies', [
            'desc' => 'Testimony description',
            'rating' => '5',
            'deleted_at' => null
        ]);
    }

    public function test_customer_cannot_delete_others_testimony(): void
    {
        $otherCustomer = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $otherChildren = Children::factory()->create([
            'user_id' => $otherCustomer->id
        ]);

        $otherUserCourse = UserCourse::factory()->create([
            'course_id' => Course::factory()->create(['mentor_id' => Mentor::factory()->create()->id])->id,
            'children_id' => $otherChildren->id
        ]);

        $otherTestimony = Testimonies::factory()->create([
            'userCourse_id' => $otherUserCourse->id
        ]);

        $response = $this->actingAs($this->customer)
            ->delete("/user/testimony/{$otherTestimony->id}");

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'Kamu tidak memiliki akses untuk menghapus data ini.');
    }

    public function test_non_customer_cannot_access_testimony_routes(): void
    {
        $data = [
            'desc' => 'Test testimony',
            'rating' => RatingEnum::FIVE->value
        ];

        // Test store
        $response = $this->actingAs($this->nonCustomer)
            ->post('/user/testimony', $data);
        $response->assertStatus(403);

        // Test update
        $response = $this->actingAs($this->nonCustomer)
            ->put("/user/testimony/{$this->testimony->id}", $data);
        $response->assertStatus(403);

        // Test delete
        $response = $this->actingAs($this->nonCustomer)
            ->delete("/user/testimony/{$this->testimony->id}");
        $response->assertStatus(403);
    }
}
