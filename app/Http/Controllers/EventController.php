<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'upcoming' => Event::upcoming()->orderBy('event_date')->paginate(8),
            'past' => Event::past()->orderByDesc('event_date')->take(6)->get(),
        ]);
    }

    public function show(Event $event)
    {
        $isPast = $event->event_date->isBefore(now()->toDateString());

        return view('events.show', [
            'event' => $event,
            'related' => Event::query()
                ->where('id', '!=', $event->id)
                ->when($isPast, fn ($q) => $q->past(), fn ($q) => $q->upcoming())
                ->orderBy('event_date', $isPast ? 'desc' : 'asc')
                ->take(3)
                ->get(),
            'prev' => Event::query()
                ->when($isPast, fn ($q) => $q->past(), fn ($q) => $q->upcoming())
                ->where('event_date', '<', $event->event_date)
                ->latest('event_date')
                ->first(),
            'next' => Event::query()
                ->when($isPast, fn ($q) => $q->past(), fn ($q) => $q->upcoming())
                ->where('event_date', '>', $event->event_date)
                ->oldest('event_date')
                ->first(),
        ]);
    }
}
