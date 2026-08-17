<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['posts', 'articles'])->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'icon' => ['required', 'string', 'in:'.implode(',', $this->icons())],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        $data['slug'] = $this->uniqueSlug(Str::slug($data['name']));

        Category::create($data);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'icon' => ['required', 'string', 'in:'.implode(',', $this->icons())],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        $data['slug'] = $this->uniqueSlug(Str::slug($data['name']), $category->id);

        $category->update($data);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists() || $category->articles()->exists()) {
            return back()->with('error', 'Kategori masih memiliki konten. Pindahkan atau hapus kontennya dulu.');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    private function icons(): array
    {
        return ['megaphone', 'trophy', 'calendar', 'palette', 'book', 'sparkle', 'chart', 'users', 'pen', 'activity'];
    }

    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug;
        $i = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
