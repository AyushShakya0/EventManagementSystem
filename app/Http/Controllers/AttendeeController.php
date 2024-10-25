<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        $attendees = Attendee::all();
        return view('attendees.index', compact('attendees'));
    }

    public function create()
    {
        $events = Event::all();
        return view('attendees.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'event_id' => 'required|exists:events,id',
        ]);

        Attendee::create($validatedData);
        return redirect()->route('attendees.index')->with('success', 'Attendee created successfully');
    }

    public function show(Attendee $attendee)
    {
        return view('attendees.show', compact('attendee'));
    }

    public function edit(Attendee $attendee)
    {
        $events = Event::all();
        return view('attendees.edit', compact('attendee', 'events'));
    }

    public function update(Request $request, Attendee $attendee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'event_id' => 'required|exists:events,id',
        ]);

        $attendee->update($validatedData);
        return redirect()->route('attendees.index')->with('success', 'Attendee updated successfully');
    }

    public function destroy(Attendee $attendee)
    {
        $attendee->delete();
        return redirect()->route('attendees.index')->with('success', 'Attendee deleted successfully');
    }
}
