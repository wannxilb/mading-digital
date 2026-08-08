<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('is_published', true)->count(),
            'totalCategories' => Category::count(),
            'totalViews' => Post::sum('views'),
            'latestPosts' => Post::with('category')->latest()->take(6)->get(),
            'postsByCategory' => Category::withCount('posts')->get(),
        ]);
    }
}
