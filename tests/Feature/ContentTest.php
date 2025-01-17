<?php

namespace Tests\Feature;

use App\Enum\Contents\ContentType;
use App\Enum\Users\RoleEnum;
use App\Models\User;
use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->withSession(['_token' => csrf_token()]);

        $this->admin = User::factory()->create([
            'role' => RoleEnum::ADMIN->value
        ]);
    }

    public function test_unauthorized_user_cannot_store_content(): void
    {
        $response = $this->post('/admin/content', []);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_non_admin_cannot_store_content(): void
    {
        $user = User::factory()->create([
            'role' => RoleEnum::CUSTOMER->value
        ]);

        $response = $this->actingAs($user)
            ->post('/admin/content', []);

        $response->assertStatus(403);
        $response->assertForbidden();
    }

    public function test_admin_can_store_content(): void
    {
        $data = [
            'title' => 'Test Content',
            'desc' => 'Test Description',
            'type' => ContentType::CARYA->value,
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'files' => [
                [
                    'file' => UploadedFile::fake()->image('content1.jpg')
                ],
                [
                    'file' => UploadedFile::fake()->image('content2.jpg')
                ]
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/content', $data);

        $response->assertStatus(302);
        if ($response->exception) {
            dump($response->exception->getMessage());
            dump(session('errors')->getBag('default')->all());
        }
        $response->assertRedirect('/admin/content');
    }

    public function test_bad_request_missing_required_fields(): void
    {
        $data = [
            'title' => 'Test Content',
            'desc' => 'Test Description',
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/content', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_bad_request_invalid_file_type(): void
    {
        $data = [
            'title' => 'Test Content',
            'desc' => 'Test Description',
            'type' => ContentType::CARYA->value,
            'thumbnail' => UploadedFile::fake()->create('document.pdf'),
            'files' => [
                [
                    'file' => UploadedFile::fake()->create('document.pdf')
                ]
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/content', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['thumbnail', 'files.0.file']);
    }

    public function test_admin_can_update_content(): void
    {
        $content = Content::factory()->create([
            'thumbnail' => 'thumbnails/image.jpg'
        ]);

        $data = [
            'title' => 'Updated Content',
            'desc' => 'Updated Description',
            'type' => ContentType::CARYA->value,
            'thumbnail' => UploadedFile::fake()->image('new_thumbnail.jpg'),
            'files' => [
                [
                    'file' => UploadedFile::fake()->image('updated_content.jpg')
                ]
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/content/{$content->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/content');
    }

    public function test_admin_can_update_content_without_files(): void
    {
        $content = Content::factory()->create([
            'thumbnail' => 'thumbnails/image.jpg'
        ]);

        $data = [
            'title' => 'Updated Content',
            'desc' => 'Updated Description',
            'type' => ContentType::CARYA->value
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/content/{$content->id}", $data);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/content');
    }

    public function test_bad_request_invalid_file_type_update(): void
    {
        $content = Content::factory()->create([
            'thumbnail' => 'thumbnails/image.jpg'
        ]);

        $data = [
            'title' => 'Updated Content',
            'desc' => 'Updated Description',
            'type' => ContentType::CARYA->value,
            'thumbnail' => UploadedFile::fake()->create('document.pdf'),
            'files' => [
                [
                    'file' => UploadedFile::fake()->create('document.pdf')
                ]
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/content/{$content->id}", $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['thumbnail', 'files.0.file']);
    }

    public function test_admin_can_delete_content(): void
    {
        $content = Content::factory()->create([
            'thumbnail' => 'thumbnails/image.jpg'
        ]);

        $response = $this->actingAs($this->admin)
            ->delete("/admin/content/{$content->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/admin/content');
    }
}
