<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query()
            ->with('category')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(fn ($w) => $w
                    ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                    ->orWhere('author', 'like', '%'.$request->string('q')->toString().'%'));
            })
            ->latest()
            ->paginate(10);

        return view('admin.articles.index', [
            'articles' => $articles,
            'statuses' => Article::STATUSES,
            'activeStatus' => $request->string('status')->toString(),
        ]);
    }

    public function create()
    {
        return view('admin.articles.create', [
            'categories' => Category::orderBy('name')->get(),
            'statuses' => Article::STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Article::create($data);

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
            'statuses' => Article::STATUSES,
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request, $article);

        $article->update($data);

        return redirect()
            ->route('admin.artikel.edit', $article)
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()
            ->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    private function validated(Request $request, ?Article $article = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'author' => ['required', 'string', 'max:120'],
            'class' => ['nullable', 'string', 'max:60'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:'.implode(',', array_keys(Article::STATUSES))],
            'review_note' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $slugBase = Str::slug($data['title']);
        $data['slug'] = $article && $article->slug === $slugBase
            ? $article->slug
            : $this->uniqueSlug($slugBase, $article?->id);

        if ($request->boolean('remove_image') && $article?->image) {
            Storage::disk('public')->delete($article->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('covers', 'public');
        }

        if (! $article) {
            $data['published_at'] = $data['status'] === Article::STATUS_PUBLISHED ? now() : null;
        } elseif ($data['status'] === Article::STATUS_PUBLISHED && ! $article->published_at) {
            $data['published_at'] = now();
        }

        return $data;
    }

    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $i = 1;
        while (Article::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
