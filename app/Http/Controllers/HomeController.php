<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()
            ->published()
            ->with('category');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->string('q')->toString().'%')
                    ->orWhere('body', 'like', '%'.$request->string('q')->toString().'%')
                    ->orWhere('excerpt', 'like', '%'.$request->string('q')->toString().'%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('category')->toString()));
        }

        $query->orderByDesc('published_at');

        return view('home', [
            'categories' => Category::withCount('publishedPosts')->get(),
            'featured' => Post::published()->featured()->with('category')->latest('published_at')->first(),
            'posts' => $query->paginate(12)->withQueryString(),
            'totalViews' => Post::published()->sum('views'),
            'totalPosts' => Post::published()->count(),
            'activeCategory' => $request->string('category')->toString(),
        ]);
    }

    public function show(Post $post)
    {
        abort_unless($post->is_published, 404);

        $post->increment('views');

        return view('posts.show', [
            'post' => $post->load('category'),
            'related' => Post::published()
                ->where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->with('category')
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function category(Category $category)
    {
        $posts = $category->posts()
            ->published()
            ->with('category')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('categories.show', [
            'category' => $category,
            'posts' => $posts,
            'categories' => Category::withCount('publishedPosts')->get(),
        ]);
    }
}
