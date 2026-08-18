<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_returns_successful_response(): void
    {
        Category::factory()->create();
        Post::factory()->create(['is_published' => true]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Mading Digital');
    }

    public function test_category_page_lists_published_posts(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id, 'is_published' => true]);

        $this->get('/kategori/'.$category->slug)
            ->assertStatus(200)
            ->assertSee($post->title);
    }

    public function test_post_detail_increments_views(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id, 'is_published' => true, 'views' => 0]);

        $this->get('/berita/'.$post->slug)->assertStatus(200);

        $this->assertSame(1, $post->refresh()->views);
    }

    public function test_draft_post_returns_404(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id, 'status' => Post::STATUS_DRAFT]);

        $this->get('/berita/'.$post->slug)->assertNotFound();
    }

    public function test_login_page_is_accessible(): void
    {
        $this->get('/admin/login')->assertStatus(200);
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertStatus(200);
    }

    public function test_student_cannot_access_admin(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($student)
            ->get('/admin')
            ->assertForbidden();
    }
}
