<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $pinned = Announcement::active()
            ->withinDateWindow()
            ->where('is_pinned', true)
            ->orderByRaw("CASE priority WHEN 'mendesak' THEN 0 WHEN 'penting' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->get();

        $others = Announcement::active()
            ->withinDateWindow()
            ->where('is_pinned', false)
            ->orderByRaw("CASE priority WHEN 'mendesak' THEN 0 WHEN 'penting' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('announcements.index', [
            'pinned' => $pinned,
            'others' => $others,
        ]);
    }
}
