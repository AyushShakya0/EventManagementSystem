<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        return Attendee::with('event')->get();
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
        return response()->json($attendee, 201);
    }

    public function show(Attendee $attendee)
    {
        return $attendee->load('event');
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
        return response()->json($attendee, 200);
    }

    public function destroy(Attendee $attendee)
    {
        $attendee->delete();
        return response()->json(null, 204);
    }
}
