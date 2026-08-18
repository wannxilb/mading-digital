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
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $postsByStatus = Post::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $articlesByStatus = Article::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $announcementsByStatus = Announcement::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'totalBerita' => $postsByStatus->sum(),
            'publishedBerita' => $postsByStatus->get(Post::STATUS_PUBLISHED, 0),
            'pendingBerita' => $postsByStatus->get(Post::STATUS_REVIEW, 0),
            'totalArtikel' => $articlesByStatus->sum(),
            'publishedArtikel' => $articlesByStatus->get(Article::STATUS_PUBLISHED, 0),
            'pendingArtikel' => $articlesByStatus->get(Article::STATUS_REVIEW, 0),
            'totalPengumuman' => $announcementsByStatus->sum(),
            'activePengumuman' => Announcement::active()->withinDateWindow()->count(),
            'pendingPengumuman' => $announcementsByStatus->get(Announcement::STATUS_PENDING, 0),
            'agendaMendatang' => Event::upcoming()->count(),
            'totalPrestasi' => Achievement::count(),
            'totalUsers' => User::count(),
            'totalViews' => DB::select("SELECT COALESCE(SUM(views),0) as total FROM posts WHERE status = 'published'")[0]->total
                + DB::select("SELECT COALESCE(SUM(views),0) as total FROM articles WHERE status = 'published'")[0]->total,
            'latestPosts' => Post::with('category')->latest()->take(5)->get(),
            'latestArticles' => Article::with('category')->latest()->take(5)->get(),
            'upcomingEvents' => Event::upcoming()->orderBy('event_date')->take(4)->get(),
            'postsByCategory' => Category::withCount('posts')->orderByDesc('posts_count')->get(),
        ]);
    }
}
