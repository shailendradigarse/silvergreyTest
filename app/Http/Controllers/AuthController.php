<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;
use Exception;
use stdClass;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone_number' => 'nullable|string|regex:/^\+?[0-9]{10,15}$/',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $validated['phone_number'],
            ]);

            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'messages' => "User create successfully",
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 201);

        } catch (ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'success' => false,
                'messages' => $e->errors(),
                'data' => new stdClass()
            ], 422);

        } catch (Exception $e) {
            // Handle other exceptions
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => new stdClass()
            ], 500);
        }
    }

    // Login an existing user
    public function login(Request $request)
    {
        try {

            // Validate the request
            $validated = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Attempt to log the user in
            if (!Auth::attempt($validated)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password.',
                    'data' => new stdClass()
                ], 401);
            }

            // Get the authenticated user
            $user = Auth::user();

            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'messages' => "login successfully",
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 200);
        } catch (ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'success' => false,
                'messages' => $e->errors(),
                'data' => new stdClass()
            ], 422);

        } catch (Exception $e) {
            // Handle other exceptions
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => new stdClass()
            ], 500);
        }

    }

    public function userProfile(Request $request)
    {
        try {
            // Get the authenticated user
            $user = $request->user();

            // Create response object
            $response = new stdClass();
            $response->user = $user;

            return response()->json([
                'success' => true,
                'message' => "get user profile successfully",
                'data' => $response
            ], 200);

        } catch (Exception $e) {
            // Create response object
            $response = new stdClass();
            $response->user = null;

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => $response
            ], 500);
        }
    }

    // Logout the user
    public function logout(Request $request)
    {
        try {
           
            $user = $request->user();
            if ($user) {
                $user->tokens()->delete();
            }

            $request->session()->invalidate();
            // Regenerate the CSRF token
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.',
                'data' => new \stdClass()
            ], 200);
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during logout. ' . $e->getMessage(),
                'data' => new \stdClass()
            ], 500);
        }
    }
}
