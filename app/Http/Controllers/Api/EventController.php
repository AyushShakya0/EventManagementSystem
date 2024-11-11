<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearer_token",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Bearer token authentication"
 * )
 */

/**
 * @OA\Tag(
 *     name="Events",
 *     description="API Endpoints for managing events"
 * )

 * @OA\Schema(
 *     schema="Event",
 *     type="object",
 *     title="Event",
 *     required={"title", "description", "date", "time", "location", "category_id"},
 *     @OA\Property(property="id", type="integer", description="ID of the event"),
 *     @OA\Property(property="title", type="string", description="Title of the event"),
 *     @OA\Property(property="description", type="string", description="Description of the event"),
 *     @OA\Property(property="date", type="string", format="date", description="Date of the event"),
 *     @OA\Property(property="time", type="string", format="time", description="Time of the event"),
 *     @OA\Property(property="location", type="string", description="Location of the event"),
 *     @OA\Property(property="category_id", type="integer", description="ID of the associated category"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
 * )
 */
class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="Get all events",
     *     tags={"Events"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all events",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Event")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Event::with('category', 'attendees')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Create a new event",
     *     tags={"Events"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "date", "time", "location", "category_id"},
     *             @OA\Property(property="title", type="string", example="Sample Event"),
     *             @OA\Property(property="description", type="string", example="This is a sample event description."),
     *             @OA\Property(property="date", type="string", format="date", example="2024-11-15"),
     *             @OA\Property(property="time", type="string", format="time", example="14:30"),
     *             @OA\Property(property="location", type="string", example="123 Main St, City"),
     *             @OA\Property(property="category_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     summary="Get an event by ID",
     *     tags={"Events"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the event"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event details",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
     */
    public function show(Event $event)
    {
        return $event->load('category', 'attendees');
    }

    /**
     * @OA\Put(
     *     path="/api/events/{id}",
     *     summary="Update an event by ID",
     *     tags={"Events"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the event"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "date", "time", "location", "category_id"},
     *             @OA\Property(property="title", type="string", example="Updated Event Title"),
     *             @OA\Property(property="description", type="string", example="Updated description."),
     *             @OA\Property(property="date", type="string", format="date", example="2024-11-20"),
     *             @OA\Property(property="time", type="string", format="time", example="16:00"),
     *             @OA\Property(property="location", type="string", example="456 Main St, City"),
     *             @OA\Property(property="category_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Event")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/events/{id}",
     *     summary="Delete an event by ID",
     *     tags={"Events"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the event"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Event deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }
}
