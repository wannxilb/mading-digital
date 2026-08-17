<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('siswa.articles.index', [
            'articles' => $articles,
        ]);
    }

    public function show(Article $article)
    {
        $this->authorizeArticle($article);

        return view('siswa.articles.show', [
            'article' => $article,
        ]);
    }

    public function create()
    {
        return view('siswa.articles.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['user_id'] = auth()->id();
        $data['author'] = auth()->user()->name;
        $data['class'] = auth()->user()->class;
        $data['status'] = $request->boolean('as_draft') ? Article::STATUS_DRAFT : Article::STATUS_REVIEW;

        Article::create($data);

        return redirect()
            ->route('siswa.karya.index')
            ->with('success', 'Karya berhasil dikirim.');
    }

    public function edit(Article $article)
    {
        $this->authorizeArticle($article);

        if (! in_array($article->status, [Article::STATUS_DRAFT, Article::STATUS_REVIEW], true)) {
            return redirect()
                ->route('siswa.karya.show', $article)
                ->with('error', 'Artikel yang sudah dipublikasikan tidak bisa diedit.');
        }

        return view('siswa.articles.edit', [
            'article' => $article,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $this->authorizeArticle($article);

        if (! in_array($article->status, [Article::STATUS_DRAFT, Article::STATUS_REVIEW], true)) {
            return redirect()
                ->route('siswa.karya.show', $article)
                ->with('error', 'Artikel yang sudah dipublikasikan tidak bisa diedit.');
        }

        $data = $this->validated($request, $article);
        $data['status'] = $request->boolean('as_draft') ? Article::STATUS_DRAFT : Article::STATUS_REVIEW;
        $data['review_note'] = null;

        $article->update($data);

        return redirect()
            ->route('siswa.karya.show', $article)
            ->with('success', 'Karya berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->authorizeArticle($article);

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()
            ->route('siswa.karya.index')
            ->with('success', 'Karya berhasil dihapus.');
    }

    private function authorizeArticle(Article $article): void
    {
        if ($article->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke artikel ini.');
        }
    }

    private function validated(Request $request, ?Article $article = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string'],
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
