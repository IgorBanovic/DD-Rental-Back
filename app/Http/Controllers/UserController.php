<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $user->update($request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|unique:users|max:50',
            'password' => 'required|
                regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/|
                min:8|
                confirmed'
        ]));
        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 204);
    }
}
