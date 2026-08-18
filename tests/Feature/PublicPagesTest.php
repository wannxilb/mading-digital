<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
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

        $this->get('/cari?q=Robotik')
            ->assertOk()
            ->assertSee($matched->title)
            ->assertDontSee($unmatched->title);
    }

    public function test_search_matches_post_body(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id, 'body' => 'Panitia mengumumkan jadwal baru.']);

        $this->get('/cari?q=jadwal')
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_search_returns_empty_state_when_no_match(): void
    {
        $category = Category::factory()->create();
        Post::factory()->create(['category_id' => $category->id]);

        $this->get('/cari?q=zyxwv-tidak-ada')
            ->assertOk()
            ->assertSee('Tidak ditemukan');
    }

    public function test_berita_list_filters_by_category_slug(): void
    {
        $pengumuman = Category::factory()->create(['name' => 'Pengumuman', 'slug' => 'pengumuman']);
        $prestasi = Category::factory()->create(['name' => 'Prestasi', 'slug' => 'prestasi']);
        $post = Post::factory()->create(['category_id' => $pengumuman->id, 'is_published' => true]);
        $other = Post::factory()->create(['category_id' => $prestasi->id, 'is_published' => true]);

        $this->get('/berita?category='.$pengumuman->slug)
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
        $this->get('/berita/tidak-ada')->assertNotFound();
    }

    public function test_category_page_excludes_draft_posts(): void
    {
        $category = Category::factory()->create();
        $published = Post::factory()->create(['category_id' => $category->id, 'status' => Post::STATUS_PUBLISHED]);
        $draft = Post::factory()->create(['category_id' => $category->id, 'status' => Post::STATUS_DRAFT]);

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
            ->assertSee('Belum ada konten di kategori ini');
    }

    public function test_home_renders_when_no_posts(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_berita_list_paginates_at_nine_per_page(): void
    {
        $category = Category::factory()->create();
        Post::factory()->create([
            'category_id' => $category->id,
            'title' => 'Post Paling Lama',
            'published_at' => now()->subDays(60),
        ]);
        Post::factory()->count(9)->create(['category_id' => $category->id, 'published_at' => now()->subDays(1)]);

        $this->get('/berita')
            ->assertOk()
            ->assertDontSee('Post Paling Lama');

        $this->get('/berita?page=2')
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

        $this->get('/berita/'.$post->slug)
            ->assertOk()
            ->assertSee('<strong>Tebal</strong>', false)
            ->assertSee('<em>miring</em>', false)
            ->assertDontSee('<script>');
    }

    public function test_agenda_page_only_shows_upcoming_events(): void
    {
        $upcoming = Event::create([
            'title' => 'Upacara Bendera',
            'event_date' => now()->addDays(3),
            'status' => Event::STATUS_AKAN_DATANG,
        ]);
        $past = Event::create([
            'title' => 'Lomba Futsal',
            'event_date' => now()->subDays(3),
            'status' => Event::STATUS_AKAN_DATANG,
        ]);

        $this->get('/agenda')
            ->assertOk()
            ->assertSee($upcoming->title)
            ->assertDontSee($past->title);
    }

    public function test_past_event_still_accessible_via_direct_url(): void
    {
        $event = Event::create([
            'title' => 'Seminar Anti Bullying',
            'event_date' => now()->subDays(5),
            'status' => Event::STATUS_AKAN_DATANG,
        ]);

        $this->get('/agenda/'.$event->id)
            ->assertOk()
            ->assertSee($event->title);
    }

    public function test_archive_command_updates_past_event_status(): void
    {
        Event::create([
            'title' => 'Event Masa Lalu',
            'event_date' => now()->subDays(2),
            'status' => Event::STATUS_AKAN_DATANG,
        ]);

        $this->artisan('event:archive')
            ->expectsOutput('1 event berhasil diarsipkan.');

        $this->assertDatabaseHas('events', [
            'title' => 'Event Masa Lalu',
            'status' => Event::STATUS_ARSIP,
        ]);
    }

    public function test_archive_command_skips_already_archived_events(): void
    {
        Event::create([
            'title' => 'Sudah Arsip',
            'event_date' => now()->subDays(2),
            'status' => Event::STATUS_ARSIP,
        ]);

        $this->artisan('event:archive')
            ->expectsOutput('0 event berhasil diarsipkan.');
    }

    public function test_archive_command_skips_future_events(): void
    {
        Event::create([
            'title' => 'Event Mendatang',
            'event_date' => now()->addDays(5),
            'status' => Event::STATUS_AKAN_DATANG,
        ]);

        $this->artisan('event:archive')
            ->expectsOutput('0 event berhasil diarsipkan.');

        $this->assertDatabaseHas('events', [
            'title' => 'Event Mendatang',
            'status' => Event::STATUS_AKAN_DATANG,
        ]);
    }
}
