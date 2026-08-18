<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::query()
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                ->orWhere('student_name', 'like', '%'.$request->string('q')->toString().'%')
                ->orWhere('competition_name', 'like', '%'.$request->string('q')->toString().'%')
            ))
            ->when($request->filled('level'), fn ($q) => $q->where('competition_level', $request->string('level')->toString()))
            ->orderByDesc('achievement_date')
            ->paginate(12)
            ->withQueryString();

        return view('achievements.index', [
            'achievements' => $achievements,
            'levels' => Achievement::LEVELS,
            'activeLevel' => $request->string('level')->toString(),
        ]);
    }

    public function show(Achievement $achievement)
    {
        return view('achievements.show', [
            'achievement' => $achievement,
            'related' => Achievement::query()
                ->where('id', '!=', $achievement->id)
                ->where('competition_level', $achievement->competition_level)
                ->orderByDesc('achievement_date')
                ->take(3)
                ->get()
                ->when(fn ($c) => $c->count() < 3, fn ($c) => $c->merge(
                    Achievement::query()
                        ->where('id', '!=', $achievement->id)
                        ->where('competition_level', '!=', $achievement->competition_level)
                        ->whereKeyNot($c->pluck('id'))
                        ->orderByDesc('achievement_date')
                        ->take(3 - $c->count())
                        ->get()
                ))
                ->values(),
            'prev' => Achievement::query()
                ->where('achievement_date', '>', $achievement->achievement_date)
                ->oldest('achievement_date')
                ->first(),
            'next' => Achievement::query()
                ->where('achievement_date', '<', $achievement->achievement_date)
                ->latest('achievement_date')
                ->first(),
        ]);
    }
}
