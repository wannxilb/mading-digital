<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $base = Announcement::active()
            ->withinDateWindow()
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                ->orWhere('content', 'like', '%'.$request->string('q')->toString().'%')
            ));

        $pinned = (clone $base)
            ->where('is_pinned', true)
            ->orderByRaw("CASE priority WHEN 'mendesak' THEN 0 WHEN 'penting' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->get();

        $others = (clone $base)
            ->where('is_pinned', false)
            ->orderByRaw("CASE priority WHEN 'mendesak' THEN 0 WHEN 'penting' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('announcements.index', [
            'pinned' => $pinned,
            'others' => $others,
        ]);
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', [
            'announcement' => $announcement,
            'prev' => Announcement::active()
                ->withinDateWindow()
                ->where('id', '!=', $announcement->id)
                ->where('created_at', '>', $announcement->created_at)
                ->oldest('created_at')
                ->first(),
            'next' => Announcement::active()
                ->withinDateWindow()
                ->where('id', '!=', $announcement->id)
                ->where('created_at', '<', $announcement->created_at)
                ->latest('created_at')
                ->first(),
        ]);
    }
}
