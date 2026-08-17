<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->string('q'));

        $results = [
            'berita' => [],
            'artikel' => [],
            'pengumuman' => [],
            'agenda' => [],
            'prestasi' => [],
        ];

        if ($q !== '') {
            $results['berita'] = Post::published()
                ->with('category')
                ->where(fn ($w) => $w
                    ->where('title', 'like', "%$q%")
                    ->orWhere('excerpt', 'like', "%$q%")
                    ->orWhere('body', 'like', "%$q%"))
                ->orderByDesc('published_at')
                ->take(6)
                ->get();

            $results['artikel'] = Article::published()
                ->with('category')
                ->where(fn ($w) => $w
                    ->where('title', 'like', "%$q%")
                    ->orWhere('excerpt', 'like', "%$q%")
                    ->orWhere('body', 'like', "%$q%"))
                ->orderByDesc('published_at')
                ->take(6)
                ->get();

            $results['pengumuman'] = Announcement::active()
                ->withinDateWindow()
                ->where(fn ($w) => $w
                    ->where('title', 'like', "%$q%")
                    ->orWhere('content', 'like', "%$q%"))
                ->orderByDesc('created_at')
                ->take(4)
                ->get();

            $results['agenda'] = Event::upcoming()
                ->where(fn ($w) => $w
                    ->where('title', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%"))
                ->orderBy('event_date')
                ->take(4)
                ->get();

            $results['prestasi'] = Achievement::query()
                ->where(fn ($w) => $w
                    ->where('title', 'like', "%$q%")
                    ->orWhere('student_name', 'like', "%$q%")
                    ->orWhere('competition_name', 'like', "%$q%"))
                ->orderByDesc('achievement_date')
                ->take(4)
                ->get();
        }

        return view('search.index', [
            'q' => $q,
            'results' => $results,
            'total' => collect($results)->flatten()->count(),
        ]);
    }
}
