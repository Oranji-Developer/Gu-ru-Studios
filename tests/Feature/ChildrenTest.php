<?php

namespace Tests\Feature;

use App\Models\Children;
use App\Models\User;
use App\Enum\Users\RoleEnum;
use App\Enum\Users\GenderEnum;
use App\Enum\Courses\AcademicClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChildrenTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);
    }

    public function test_unauthorized_user_cannot_store_children(): void
    {
        $response = $this->post('/user/children', []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_non_customer_cannot_store_children(): void
    {
        $user = User::factory()->create([
            'role' => RoleEnum::ADMIN->value
        ]);

        $response = $this->actingAs($user)
            ->post('/user/children', []);

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_customer_can_store_children(): void
    {
        $data = [
            'name' => 'Test Child',
            'class' => AcademicClass::CLASS1->value,
            'gender' => GenderEnum::MA->value,
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/children', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/user/children');
        $response->assertSessionHas('success', 'Berhasil menambahkan data anak!!');

        $this->assertDatabaseHas('children', [
            'name' => 'Test Child',
            'class' => AcademicClass::CLASS1->value,
            'gender' => GenderEnum::MA->value,
            'user_id' => $this->customer->id
        ]);
    }

    public function test_bad_request_missing_required_field(): void
    {
        $data = [
            'name' => '',
            'class' => AcademicClass::CLASS1->value,
            'gender' => GenderEnum::MA->value,
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/children', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_bad_request_invalid_gender(): void
    {
        $data = [
            'name' => 'Test Child',
            'class' => AcademicClass::CLASS1->value,
            'gender' => 'invalid_gender',
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/children', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['gender']);
    }

    public function test_bad_request_invalid_class(): void
    {
        $data = [
            'name' => 'Test Child',
            'class' => 'invalid_class',
            'gender' => GenderEnum::MA->value,
        ];

        $response = $this->actingAs($this->customer)
            ->post('/user/children', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['class']);
    }

    public function test_customer_can_update_children(): void
    {
        $children = Children::factory()->create([
            'user_id' => $this->customer->id
        ]);

        $data = [
            'name' => 'Updated Child Name',
            'class' => AcademicClass::CLASS2->value,
            'gender' => GenderEnum::FE->value,
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/children/{$children->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/user/children');
        $response->assertSessionHas('success', 'Berhasil mengubah data anak!!');

        $this->assertDatabaseHas('children', [
            'id' => $children->id,
            'name' => 'Updated Child Name',
            'class' => AcademicClass::CLASS2->value,
            'gender' => GenderEnum::FE->value,
        ]);
    }

    public function test_customer_cannot_update_other_customer_children(): void
    {
        $otherCustomer = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $children = Children::factory()->create([
            'user_id' => $otherCustomer->id
        ]);

        $data = [
            'name' => 'Updated Child Name',
            'class' => AcademicClass::CLASS2->value,
            'gender' => GenderEnum::FE->value,
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/children/{$children->id}", $data);

        $response->assertStatus(302);
    }

    public function test_bad_request_invalid_data_on_update(): void
    {
        $children = Children::factory()->create([
            'user_id' => $this->customer->id
        ]);

        $data = [
            'name' => '',
            'class' => 'invalid_class',
            'gender' => 'invalid_gender',
        ];

        $response = $this->actingAs($this->customer)
            ->put("/user/children/{$children->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'class', 'gender']);
    }
}
