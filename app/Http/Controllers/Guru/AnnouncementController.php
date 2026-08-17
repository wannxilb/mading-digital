<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function create()
    {
        return view('guru.announcements.create', [
            'priorities' => Announcement::PRIORITIES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'priority' => ['required', 'in:'.implode(',', array_keys(Announcement::PRIORITIES))],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        Announcement::create($data + [
            'created_by' => auth()->id(),
            'status' => Announcement::STATUS_AKTIF,
            'is_pinned' => false,
        ]);

        return redirect()
            ->route('guru.dashboard')
            ->with('success', 'Pengumuman berhasil dipublikasikan.');
    }
}
