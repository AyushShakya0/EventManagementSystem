<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        $attendees = Attendee::all();
        return response()->json($attendees);
    }

    public function show($id)
    {
        $attendee = Attendee::findOrFail($id);
        return response()->json($attendee);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:attendees,email',
            'event_id' => 'required|exists:events,id',
        ]);

        Attendee::create($validatedData);
        return response()->json(['message' => 'Attendee created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $attendee = Attendee::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:attendees,email,' . $attendee->id,
            'event_id' => 'required|exists:events,id',
        ]);

        $attendee->update($validatedData);
        return response()->json(['message' => 'Attendee updated successfully']);
    }

    public function destroy($id)
    {
        $attendee = Attendee::findOrFail($id);
        $attendee->delete();

        return response()->json(['message' => 'Attendee deleted successfully']);
    }
}
