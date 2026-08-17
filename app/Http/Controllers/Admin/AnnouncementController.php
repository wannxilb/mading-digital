<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->string('q')->toString().'%');
            })
            ->latest()
            ->paginate(10);

        return view('admin.announcements.index', [
            'announcements' => $announcements,
            'priorities' => Announcement::PRIORITIES,
            'statuses' => Announcement::STATUSES,
        ]);
    }

    public function create()
    {
        return view('admin.announcements.create', [
            'priorities' => Announcement::PRIORITIES,
            'statuses' => Announcement::STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Announcement::create($data + ['created_by' => auth()->id()]);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil disimpan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', [
            'announcement' => $announcement,
            'priorities' => Announcement::PRIORITIES,
            'statuses' => Announcement::STATUSES,
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $this->validated($request);

        $announcement->update($data);

        return redirect()
            ->route('admin.pengumuman.edit', $announcement)
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'priority' => ['required', 'in:'.implode(',', array_keys(Announcement::PRIORITIES))],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_pinned' => ['nullable', 'boolean'],
            'status' => ['required', 'in:'.implode(',', array_keys(Announcement::STATUSES))],
        ]) + ['is_pinned' => $request->boolean('is_pinned')];
    }
}
