<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(fn ($w) => $w
                    ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                    ->orWhere('student_name', 'like', '%'.$request->string('q')->toString().'%'));
            })
            ->orderByDesc('achievement_date')
            ->paginate(10);

        return view('admin.achievements.index', [
            'achievements' => $achievements,
            'levels' => Achievement::LEVELS,
        ]);
    }

    public function create()
    {
        return view('admin.achievements.create', ['levels' => Achievement::LEVELS]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Achievement::create($data);

        return redirect()
            ->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil disimpan.');
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', [
            'achievement' => $achievement,
            'levels' => Achievement::LEVELS,
        ]);
    }

    public function update(Request $request, Achievement $achievement)
    {
        $data = $this->validated($request, $achievement);

        $achievement->update($data);

        return redirect()
            ->route('admin.prestasi.edit', $achievement)
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        if ($achievement->image) {
            Storage::disk('public')->delete($achievement->image);
        }

        $achievement->delete();

        return redirect()
            ->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }

    private function validated(Request $request, ?Achievement $achievement = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'student_name' => ['nullable', 'string', 'max:120'],
            'class' => ['nullable', 'string', 'max:60'],
            'competition_name' => ['nullable', 'string', 'max:255'],
            'competition_level' => ['required', 'in:'.implode(',', array_keys(Achievement::LEVELS))],
            'rank' => ['nullable', 'string', 'max:60'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'achievement_date' => ['nullable', 'date'],
        ]);

        if ($request->boolean('remove_image') && $achievement?->image) {
            Storage::disk('public')->delete($achievement->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('achievements', 'public');
        }

        return $data;
    }
}
