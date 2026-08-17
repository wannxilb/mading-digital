<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('siswa.dashboard', [
            'myArticles' => Article::where('user_id', $user->id)->latest()->take(5)->get(),
            'totalArticles' => Article::where('user_id', $user->id)->count(),
            'publishedCount' => Article::where('user_id', $user->id)->where('status', Article::STATUS_PUBLISHED)->count(),
            'reviewCount' => Article::where('user_id', $user->id)->where('status', Article::STATUS_REVIEW)->count(),
            'draftCount' => Article::where('user_id', $user->id)->where('status', Article::STATUS_DRAFT)->count(),
            'totalViews' => Article::where('user_id', $user->id)->sum('views'),
        ]);
    }
}
