<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\Post;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->string('type', 'all')->toString();

        $pendingPosts = Post::pendingReview()->with('category')->latest();
        $pendingArticles = Article::pendingReview()->with('category', 'user')->latest();
        $pendingAnnouncements = Announcement::pendingReview()->with('creator')->latest();

        if ($type === 'berita') {
            $posts = $pendingPosts->paginate(10);
            $articles = collect();
            $announcements = collect();
        } elseif ($type === 'artikel') {
            $posts = collect();
            $articles = $pendingArticles->paginate(10);
            $announcements = collect();
        } elseif ($type === 'pengumuman') {
            $posts = collect();
            $articles = collect();
            $announcements = $pendingAnnouncements->paginate(10);
        } else {
            $posts = $pendingPosts->take(10)->get();
            $articles = $pendingArticles->take(10)->get();
            $announcements = $pendingAnnouncements->take(10)->get();
        }

        return view('admin.approval.index', compact('posts', 'articles', 'announcements', 'type'));
    }

    public function approvePost(Post $post)
    {
        $post->update([
            'status' => Post::STATUS_PUBLISHED,
            'review_note' => null,
            'published_at' => $post->published_at ?? now(),
        ]);

        return back()->with('success', 'Berita "'.$post->title.'" berhasil dipublikasikan.');
    }

    public function rejectPost(Post $post)
    {
        request()->validate([
            'review_note' => ['required', 'string', 'max:1000'],
        ]);

        $post->update([
            'status' => Post::STATUS_DRAFT,
            'review_note' => request('review_note'),
        ]);

        return back()->with('success', 'Berita "'.$post->title.'" ditolak.');
    }

    public function approveArticle(Article $article)
    {
        $article->update([
            'status' => Article::STATUS_PUBLISHED,
            'review_note' => null,
            'published_at' => $article->published_at ?? now(),
        ]);

        return back()->with('success', 'Artikel "'.$article->title.'" berhasil dipublikasikan.');
    }

    public function rejectArticle(Article $article)
    {
        request()->validate([
            'review_note' => ['required', 'string', 'max:1000'],
        ]);

        $article->update([
            'status' => Article::STATUS_ARCHIVED,
            'review_note' => request('review_note'),
        ]);

        return back()->with('success', 'Artikel "'.$article->title.'" ditolak.');
    }

    public function approveAnnouncement(Announcement $announcement)
    {
        $announcement->update([
            'status' => Announcement::STATUS_AKTIF,
            'review_note' => null,
        ]);

        return back()->with('success', 'Pengumuman "'.$announcement->title.'" berhasil dipublikasikan.');
    }

    public function rejectAnnouncement(Announcement $announcement)
    {
        request()->validate([
            'review_note' => ['required', 'string', 'max:1000'],
        ]);

        $announcement->update([
            'status' => Announcement::STATUS_DRAFT,
            'review_note' => request('review_note'),
        ]);

        return back()->with('success', 'Pengumuman "'.$announcement->title.'" ditolak.');
    }
}
