<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Api\User\RegisterUserRequest;

class AuthController extends Controller
{
    

    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_USER,
        ]);

        $token = $user->createToken('PaperApp')->plainTextToken;

        return response()->json([
            'success' => true,
            'status' => Response::HTTP_CREATED,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
            ],
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found',
            ], Response::HTTP_NOT_FOUND);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Password is incorrect',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('PaperApp')->plainTextToken;

        return response()->json([
            'success' => true,
            'status' => Response::HTTP_OK,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
            ],
            'token' => $token,
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'status' => Response::HTTP_OK,
            'message' => 'Successfully logged out',
        ], Response::HTTP_OK);
    }
}
