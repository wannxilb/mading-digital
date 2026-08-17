<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\Category;
use App\Models\Event;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalBerita' => Post::count(),
            'publishedBerita' => Post::published()->count(),
            'totalArtikel' => Article::count(),
            'publishedArtikel' => Article::published()->count(),
            'pendingArtikel' => Article::pendingReview()->count(),
            'totalPengumuman' => Announcement::count(),
            'activePengumuman' => Announcement::active()->withinDateWindow()->count(),
            'agendaMendatang' => Event::upcoming()->count(),
            'totalPrestasi' => Achievement::count(),
            'totalUsers' => User::count(),
            'totalViews' => Post::sum('views') + Article::sum('views'),
            'latestPosts' => Post::with('category')->latest()->take(5)->get(),
            'latestArticles' => Article::with('category')->latest()->take(5)->get(),
            'upcomingEvents' => Event::upcoming()->orderBy('event_date')->take(4)->get(),
            'postsByCategory' => Category::withCount('posts')->orderByDesc('posts_count')->get(),
        ]);
    }
}
