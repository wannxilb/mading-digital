<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    private function postPayload(array $overrides = []): array
    {
        $category = Category::factory()->create();

        return array_merge([
            'title' => 'Cerita Baru',
            'category_id' => $category->id,
            'author' => 'Redaksi',
            'excerpt' => 'Ringkasan cerita.',
            'body' => '**Isi** cerita lengkap.',
            'is_published' => '1',
            'is_featured' => '0',
        ], $overrides);
    }

    public function test_admin_can_create_published_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post('/admin/posts', $this->postPayload())
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title' => 'Cerita Baru',
            'is_published' => true,
        ]);
    }

    public function test_create_post_requires_mandatory_fields(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from('/admin/posts/baru')
            ->post('/admin/posts', [])
            ->assertRedirect('/admin/posts/baru')
            ->assertSessionHasErrors(['title', 'category_id', 'author', 'body']);
    }

    public function test_admin_can_update_post_and_slug_regenerates(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create(['title' => 'Judul Lama']);

        $this->actingAs($admin)
            ->put('/admin/posts/'.$post->id, $this->postPayload(['title' => 'Judul Baru']))
            ->assertRedirect();

        $post->refresh();
        $this->assertSame('Judul Baru', $post->title);
        $this->assertSame('judul-baru', $post->slug);
    }

    public function test_unpublishing_a_post_makes_it_404_on_public_site(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create(['is_published' => true]);

        $this->actingAs($admin)
            ->put('/admin/posts/'.$post->id, $this->postPayload(['title' => $post->title, 'is_published' => '0']))
            ->assertRedirect();

        $this->get('/baca/'.$post->refresh()->slug)->assertNotFound();
    }

    public function test_admin_can_delete_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create();

        $this->actingAs($admin)
            ->delete('/admin/posts/'.$post->id)
            ->assertRedirect();

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_cover_image_is_stored_on_create_and_removed_on_delete(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post('/admin/posts', $this->postPayload([
                'image' => UploadedFile::fake()->image('sampul.jpg'),
            ]))
            ->assertRedirect();

        $post = Post::where('title', 'Cerita Baru')->first();
        $this->assertNotNull($post);
        $this->assertNotNull($post->image);
        Storage::disk('public')->assertExists($post->image);

        $this->actingAs($admin)
            ->delete('/admin/posts/'.$post->id)
            ->assertRedirect();

        Storage::disk('public')->assertMissing($post->image);
    }

    public function test_reject_non_image_upload(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from('/admin/posts/baru')
            ->post('/admin/posts', $this->postPayload([
                'image' => UploadedFile::fake()->create('dokumen.txt'),
            ]))
            ->assertRedirect('/admin/posts/baru')
            ->assertSessionHasErrors('image');
    }

    public function test_duplicate_titles_get_unique_slugs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/admin/posts', $this->postPayload(['title' => 'Berita Sama']));
        $this->actingAs($admin)->post('/admin/posts', $this->postPayload(['title' => 'Berita Sama']));

        $this->assertDatabaseHas('posts', ['title' => 'Berita Sama', 'slug' => 'berita-sama']);
        $this->assertDatabaseHas('posts', ['title' => 'Berita Sama', 'slug' => 'berita-sama-1']);
    }

    public function test_new_post_starts_with_zero_views(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/admin/posts', $this->postPayload());

        $this->assertDatabaseHas('posts', ['title' => 'Cerita Baru', 'views' => 0]);
    }
}
