<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::query()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q')->toString().'%'))
            ->when($request->filled('period'), function ($q) use ($request) {
                if ($request->string('period')->toString() === 'mendatang') {
                    $q->upcoming();
                } elseif ($request->string('period')->toString() === 'riwayat') {
                    $q->past();
                }
            })
            ->orderBy('event_date')
            ->paginate(10);

        return view('admin.events.index', ['events' => $events]);
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Event::create($data + ['created_by' => auth()->id()]);

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil disimpan.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', ['event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validated($request, $event);

        $event->update($data);

        return redirect()
            ->route('admin.agenda.edit', $event)
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }

    private function validated(Request $request, ?Event $event = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'organizer' => ['nullable', 'string', 'max:120'],
            'poster' => ['nullable', 'image', 'max:4096'],
            'remove_poster' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_poster') && $event?->poster) {
            Storage::disk('public')->delete($event->poster);
            $data['poster'] = null;
        }

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        return $data;
    }
}
