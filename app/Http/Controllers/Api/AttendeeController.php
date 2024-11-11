<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
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
 *     name="Attendees",
 *     description="API Endpoints for managing attendees"
 * )
 * @OA\Schema(
 *     schema="Attendee",
 *     type="object",
 *     title="Attendee",
 *     required={"name", "email", "phone", "event_id"},
 *     @OA\Property(property="id", type="integer", description="ID of the attendee"),
 *     @OA\Property(property="name", type="string", description="Name of the attendee"),
 *     @OA\Property(property="email", type="string", format="email", description="Email of the attendee"),
 *     @OA\Property(property="phone", type="string", description="Phone number of the attendee"),
 *     @OA\Property(property="event_id", type="integer", description="ID of the associated event"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp")
 * )
 */
class AttendeeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/attendees",
     *     summary="Get all attendees",
     *     tags={"Attendees"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of all attendees",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Attendee")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Attendee::with('event')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/attendees",
     *     summary="Create a new attendee",
     *     tags={"Attendees"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "event_id"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="1234567890"),
     *             @OA\Property(property="event_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Attendee created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Attendee")
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
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'event_id' => 'required|exists:events,id',
        ]);

        $attendee = Attendee::create($validatedData);
        return response()->json($attendee, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/attendees/{id}",
     *     summary="Get an attendee by ID",
     *     tags={"Attendees"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the attendee"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendee details",
     *         @OA\JsonContent(ref="#/components/schemas/Attendee")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attendee not found"
     *     )
     * )
     */
    public function show(Attendee $attendee)
    {
        return $attendee->load('event');
    }

    /**
     * @OA\Put(
     *     path="/api/attendees/{id}",
     *     summary="Update an attendee by ID",
     *     tags={"Attendees"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the attendee"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendee updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Attendee")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attendee not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, Attendee $attendee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
        ]);

        $attendee->update($validatedData);
        return response()->json($attendee, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/attendees/{id}",
     *     summary="Delete an attendee by ID",
     *     tags={"Attendees"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the attendee"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Attendee deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Attendee deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Attendee not found"
     *     )
     * )
     */
    public function destroy(Attendee $attendee)
    {
        $attendee->delete();
        return response()->json([
            'message' => 'Attendee deleted successfully',
        ]);
    }
}
