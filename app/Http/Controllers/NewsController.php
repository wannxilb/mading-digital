<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::published()
            ->with('category')
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->string('category')->toString())))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(fn ($w) => $w
                    ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                    ->orWhere('excerpt', 'like', '%'.$request->string('q')->toString().'%'));
            })
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('posts.index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        abort_unless($post->is_published, 404);

        $post->increment('views');

        return view('posts.show', [
            'post' => $post->load('category'),
            'related' => collect()
                ->merge(
                    Post::published()
                        ->whereKeyNot($post->id)
                        ->where('category_id', $post->category_id)
                        ->with('category')
                        ->latest('published_at')
                        ->take(3)
                        ->get()
                )
                ->when(fn ($c) => $c->count() < 3, fn ($c) => $c->merge(
                    Post::published()
                        ->whereKeyNot($post->id)
                        ->where('category_id', '!=', $post->category_id)
                        ->whereKeyNot($c->pluck('id'))
                        ->with('category')
                        ->latest('published_at')
                        ->take(3 - $c->count())
                        ->get()
                ))
                ->values(),
            'prev' => Post::published()
                ->where('published_at', '>', $post->published_at)
                ->oldest('published_at')
                ->first(),
            'next' => Post::published()
                ->where('published_at', '<', $post->published_at)
                ->latest('published_at')
                ->first(),
        ]);
    }
}
