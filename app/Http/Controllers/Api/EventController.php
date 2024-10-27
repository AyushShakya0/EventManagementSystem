<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::with('category', 'attendees')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $event = Event::create($validatedData);
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return $event->load('category', 'attendees');
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $event->update($validatedData);
        return response()->json($event, 200);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }
}
