<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_renders_published_posts(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id, 'is_published' => true]);

        $this->get('/')
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_search_filters_posts_by_title(): void
    {
        $category = Category::factory()->create();
        $matched = Post::factory()->create(['category_id' => $category->id, 'title' => 'Robotik Juara Nasional']);
        $unmatched = Post::factory()->create(['category_id' => $category->id, 'title' => 'Lomba Melukis']);

        $this->get('/?q=Robotik')
            ->assertOk()
            ->assertSee($matched->title)
            ->assertDontSee($unmatched->title);
    }

    public function test_search_matches_post_body(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id, 'body' => 'Panitia mengumumkan jadwal baru.']);

        $this->get('/?q=jadwal')
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_search_returns_empty_state_when_no_match(): void
    {
        $category = Category::factory()->create();
        Post::factory()->create(['category_id' => $category->id]);

        $this->get('/?q=zyxwv-tidak-ada')
            ->assertOk()
            ->assertSee('Belum ada cerita ditemukan');
    }

    public function test_home_filters_by_category_slug(): void
    {
        $pengumuman = Category::factory()->create(['name' => 'Pengumuman', 'slug' => 'pengumuman']);
        $prestasi = Category::factory()->create(['name' => 'Prestasi', 'slug' => 'prestasi']);
        $post = Post::factory()->create(['category_id' => $pengumuman->id]);
        $other = Post::factory()->create(['category_id' => $prestasi->id]);

        $this->get('/?category='.$pengumuman->slug)
            ->assertOk()
            ->assertSee($post->title)
            ->assertDontSee($other->title);
    }

    public function test_unknown_category_slug_returns_404(): void
    {
        $this->get('/kategori/tidak-ada')->assertNotFound();
    }

    public function test_unknown_post_slug_returns_404(): void
    {
        $this->get('/baca/tidak-ada')->assertNotFound();
    }

    public function test_category_page_excludes_draft_posts(): void
    {
        $category = Category::factory()->create();
        $published = Post::factory()->create(['category_id' => $category->id, 'is_published' => true]);
        $draft = Post::factory()->create(['category_id' => $category->id, 'is_published' => false]);

        $this->get('/kategori/'.$category->slug)
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee($draft->title);
    }

    public function test_category_page_renders_empty_state(): void
    {
        $category = Category::factory()->create();

        $this->get('/kategori/'.$category->slug)
            ->assertOk()
            ->assertSee('Belum ada cerita di halte ini');
    }

    public function test_home_renders_when_no_posts(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_public_list_paginates_at_twelve_per_page(): void
    {
        $category = Category::factory()->create();
        Post::factory()->create([
            'category_id' => $category->id,
            'title' => 'Post Paling Lama',
            'published_at' => now()->subDays(60),
        ]);
        Post::factory()->count(12)->create(['category_id' => $category->id, 'published_at' => now()->subDays(1)]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Post Paling Lama');

        $this->get('/?page=2')
            ->assertOk()
            ->assertSee('Post Paling Lama');
    }

    public function test_markdown_body_is_rendered_and_raw_html_is_stripped(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'category_id' => $category->id,
            'body' => "**Tebal** dan *miring*\n\n<script>alert('xss')</script>",
        ]);

        $this->get('/baca/'.$post->slug)
            ->assertOk()
            ->assertSee('<strong>Tebal</strong>', false)
            ->assertSee('<em>miring</em>', false)
            ->assertDontSee('<script>');
    }
}
