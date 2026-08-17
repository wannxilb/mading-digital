<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        return view('guru.dashboard', [
            'pendingReview' => Article::pendingReview()->with('category', 'user')->latest()->take(10)->get(),
            'pendingCount' => Article::pendingReview()->count(),
            'publishedCount' => Article::published()->count(),
            'totalArticles' => Article::count(),
            'recentAnnouncements' => Announcement::latest()->take(5)->get(),
        ]);
    }
}
