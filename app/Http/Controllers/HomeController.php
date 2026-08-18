<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $featured = Post::published()->featured()->with('category')->latest('published_at')->first()
            ?? Post::published()->with('category')->latest('published_at')->first();

        return view('home', [
            'categories' => Category::withCount(['publishedPosts', 'publishedArticles'])->orderBy('name')->get(),
            'featured' => $featured,
            'berita' => Post::published()
                ->with('category')
                ->when($featured, fn ($q) => $q->whereKeyNot($featured->id))
                ->latest('published_at')
                ->take(5)
                ->get(),
            'artikel' => Article::published()->with('category')->latest('published_at')->take(4)->get(),
            'pengumuman' => Announcement::active()
                ->withinDateWindow()
                ->orderByDesc('is_pinned')
                ->orderByRaw("CASE priority WHEN 'mendesak' THEN 0 WHEN 'penting' THEN 1 ELSE 2 END")
                ->orderByDesc('created_at')
                ->take(4)
                ->get(),
            'agenda' => Event::upcoming()->orderBy('event_date')->take(4)->get(),
            'prestasi' => Achievement::orderByDesc('achievement_date')->take(4)->get(),
            'totalBerita' => Post::published()->count(),
            'totalArtikel' => Article::published()->count(),
            'totalPrestasi' => Achievement::count(),
            'totalViews' => DB::select("SELECT COALESCE(SUM(views),0) as total FROM posts WHERE status = 'published'")[0]->total
                + DB::select("SELECT COALESCE(SUM(views),0) as total FROM articles WHERE status = 'published'")[0]->total,
        ]);
    }

    public function category(Category $category)
    {
        $berita = $category->posts()->published()->with('category')->orderByDesc('published_at')->get();
        $artikel = $category->articles()->published()->with('category')->orderByDesc('published_at')->get();

        return view('categories.show', [
            'category' => $category,
            'berita' => $berita,
            'artikel' => $artikel,
        ]);
    }
}
