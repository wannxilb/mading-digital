<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query()
            ->with('category', 'user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(10);

        return view('guru.review.index', [
            'articles' => $articles,
            'statuses' => Article::STATUSES,
            'activeStatus' => $request->string('status')->toString(),
        ]);
    }

    public function show(Article $article)
    {
        return view('guru.review.show', [
            'article' => $article,
        ]);
    }

    public function approve(Article $article)
    {
        $article->update([
            'status' => Article::STATUS_PUBLISHED,
            'review_note' => null,
            'published_at' => now(),
        ]);

        return redirect()
            ->route('guru.review.show', $article)
            ->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function reject(Article $article)
    {
        request()->validate([
            'review_note' => ['required', 'string', 'max:1000'],
        ]);

        $article->update([
            'status' => Article::STATUS_ARCHIVED,
            'review_note' => request('review_note'),
        ]);

        return redirect()
            ->route('guru.review.show', $article)
            ->with('success', 'Artikel ditolak dan diarsipkan.');
    }
}
