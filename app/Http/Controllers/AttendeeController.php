<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        $attendees = Attendee::with('event')->get(); // Assuming Attendee has a relationship with Event
        $events = Event::all();


        return view('attendees.index', compact('attendees', 'events'));
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

        $attendee = Attendee::create($validatedData);
        // Return the new attendee with the event details included
        return response()->json([
            'id' => $attendee->id,
            'name' => $attendee->name,
            'email' => $attendee->email,
            'phone' => $attendee->phone,
            'event_id' => $attendee->event_id, // Send event ID
            'event_title' => $attendee->event->title, // Send the event's title
        ]);
        // return redirect()->route('attendees.index')->with('success', 'Attendee created successfully');
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

        // Return the new attendee with the event details included
        return response()->json([
            'id' => $attendee->id,
            'name' => $attendee->name,
            'email' => $attendee->email,
            'phone' => $attendee->phone,
            'event_id' => $attendee->event_id, // Send event ID
            'event_title' => $attendee->event->title, // Send the event's title
        ]);
    }

    public function destroy($id)
    {
        $attendee = Attendee::findOrFail($id);
        $attendee->delete();

        return response()->json(['success' => true, 'message' => 'Attendee deleted successfully']);
    }
}
