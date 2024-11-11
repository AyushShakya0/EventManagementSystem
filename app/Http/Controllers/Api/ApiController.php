<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Test",
 *      description="API for Everything"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      description="Enter JWT token to authorize"
 * )
 */
class ApiController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User Signup Successfully"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function registerUser(Request $request)
    {
        try {
            $userdata = $request->validate([
                'name' => 'string|required',
                'password' => 'min:8|required',
                'email' => 'required|email|unique:users,email',
            ]);

            $user = User::create([
                'name' => $userdata['name'],
                'email' => $userdata['email'],
                'password' => Hash::make($userdata['password']),
            ]);

            return response()->json([
                "message" => "User Signup Successfully",
                "user" => $user
            ]);
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login Successful"),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Login unsuccessful"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function loginUser(Request $request)
    {
        try {
            $user_login_data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8'
            ]);

            $user = User::where('email', $user_login_data['email'])->first();

            if ($user && Hash::check($user_login_data['password'], $user->password)) {
                $token = $user->createToken('user-token')->plainTextToken;
                return response()->json([
                    "message" => "Login Successful",
                    "token" => $token
                ]);
            } else {
                return response()->json([
                    "message" => "Login Unsuccessful",
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([$e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/user/profile",
     *     summary="Get user profile",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User profile retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function getUserProfile(Request $request)
    {
        // Retrieve and return user profile details
        return response()->json(auth()->user());
    }
}
