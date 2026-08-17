<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::published()
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

        return view('articles.index', ['articles' => $articles]);
    }

    public function show(Article $article)
    {
        abort_unless($article->is_published, 404);

        $article->increment('views');

        return view('articles.show', [
            'article' => $article->load('category'),
            'related' => collect()
                ->merge(
                    Article::published()
                        ->whereKeyNot($article->id)
                        ->where('category_id', $article->category_id)
                        ->with('category')
                        ->latest('published_at')
                        ->take(3)
                        ->get()
                )
                ->when(fn ($c) => $c->count() < 3, fn ($c) => $c->merge(
                    Article::published()
                        ->whereKeyNot($article->id)
                        ->where('category_id', '!=', $article->category_id)
                        ->whereKeyNot($c->pluck('id'))
                        ->with('category')
                        ->latest('published_at')
                        ->take(3 - $c->count())
                        ->get()
                ))
                ->values(),
            'prev' => Article::published()
                ->where('published_at', '>', $article->published_at)
                ->oldest('published_at')
                ->first(),
            'next' => Article::published()
                ->where('published_at', '<', $article->published_at)
                ->latest('published_at')
                ->first(),
        ]);
    }
}
