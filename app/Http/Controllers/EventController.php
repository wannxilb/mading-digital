<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::query()
            ->upcoming()
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('title', 'like', '%'.$request->string('q')->toString().'%')
                ->orWhere('location', 'like', '%'.$request->string('q')->toString().'%')
                ->orWhere('organizer', 'like', '%'.$request->string('q')->toString().'%')
            ))
            ->orderBy('event_date')
            ->paginate(8)
            ->withQueryString();

        return view('events.index', [
            'events' => $events,
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
