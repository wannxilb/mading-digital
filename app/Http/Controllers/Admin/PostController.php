<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->with('category')
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(fn ($w) => $w
                    ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                    ->orWhere('author', 'like', '%'.$request->string('q')->toString().'%'));
            })
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $post = Post::create($data);

        if ($request->boolean('is_published')) {
            $post->update(['status' => Post::STATUS_PUBLISHED, 'published_at' => now()]);
        }

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diterbitkan.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);

        $post->update($data);

        return redirect()
            ->route('admin.berita.edit', $post)
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'author' => ['required', 'string', 'max:120'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string'],
            'status' => ['nullable', 'in:'.implode(',', array_keys(Post::STATUSES))],
            'review_note' => ['nullable', 'string', 'max:1000'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

        $slugBase = Str::slug($data['title']);
        $data['slug'] = $post && $post->slug === $slugBase
            ? $post->slug
            : $this->uniqueSlug($slugBase, $post?->id);

        if ($request->boolean('remove_image') && $post?->image) {
            Storage::disk('public')->delete($post->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('covers', 'public');
        }

        if (! $post) {
            $data['status'] = $data['is_published'] ? Post::STATUS_PUBLISHED : Post::STATUS_DRAFT;
            $data['published_at'] = $data['is_published'] ? now() : null;
        } else {
            if (isset($data['status'])) {
                // Admin can manually set status on update
            } elseif ($data['is_published'] && $post->status !== Post::STATUS_PUBLISHED) {
                $data['status'] = Post::STATUS_PUBLISHED;
            } elseif (! $data['is_published'] && $post->status === Post::STATUS_PUBLISHED) {
                $data['status'] = Post::STATUS_DRAFT;
            }

            if (($data['status'] ?? $post->status) === Post::STATUS_PUBLISHED && ! $post->published_at) {
                $data['published_at'] = now();
            }
        }

        return $data;
    }

    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $i = 1;
        while (Post::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
