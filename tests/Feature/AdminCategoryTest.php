<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post('/admin/kategori', ['name' => 'Olahraga', 'icon' => 'trophy', 'description' => 'Kabar olahraga'])
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['name' => 'Olahraga', 'slug' => 'olahraga']);
    }

    public function test_create_category_rejects_invalid_icon(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from('/admin/kategori')
            ->post('/admin/kategori', ['name' => 'Olahraga', 'icon' => 'nope'])
            ->assertRedirect('/admin/kategori')
            ->assertSessionHasErrors('icon');
    }

    public function test_admin_can_update_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create(['name' => 'Lama']);

        $this->actingAs($admin)
            ->put('/admin/kategori/'.$category->id, ['name' => 'Baru', 'icon' => 'book'])
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['name' => 'Baru', 'slug' => 'baru']);
    }

    public function test_admin_can_delete_empty_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $this->actingAs($admin)
            ->delete('/admin/kategori/'.$category->id)
            ->assertRedirect();

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_cannot_delete_category_that_has_posts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        Post::factory()->create(['category_id' => $category->id]);

        $this->actingAs($admin)
            ->delete('/admin/kategori/'.$category->id)
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_duplicate_category_names_get_unique_slugs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/admin/kategori', ['name' => 'Olahraga', 'icon' => 'trophy']);
        $this->actingAs($admin)->post('/admin/kategori', ['name' => 'Olahraga', 'icon' => 'trophy']);

        $this->assertDatabaseHas('categories', ['name' => 'Olahraga', 'slug' => 'olahraga']);
        $this->assertDatabaseHas('categories', ['name' => 'Olahraga', 'slug' => 'olahraga-1']);
    }

    public function test_rename_to_existing_name_keeps_own_slug_and_gets_unique(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $olahraga = Category::factory()->create(['name' => 'Olahraga', 'slug' => 'olahraga']);
        $sport = Category::factory()->create(['name' => 'Sport', 'slug' => 'sport']);

        $this->actingAs($admin)
            ->put('/admin/kategori/'.$sport->id, ['name' => 'Olahraga', 'icon' => 'book'])
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['name' => 'Olahraga', 'slug' => 'olahraga']);
        $this->assertDatabaseHas('categories', ['name' => 'Olahraga', 'slug' => 'olahraga-1']);

        $this->actingAs($admin)
            ->put('/admin/kategori/'.$olahraga->id, ['name' => 'Olahraga', 'icon' => 'trophy'])
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['name' => 'Olahraga', 'slug' => 'olahraga']);
    }

    public function test_category_list_shows_post_count(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();
        Post::factory()->count(3)->create(['category_id' => $category->id]);

        $this->actingAs($admin)
            ->get('/admin/kategori')
            ->assertOk()
            ->assertSee('3 berita');
    }
}
