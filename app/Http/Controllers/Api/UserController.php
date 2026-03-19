<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): Collection
    {
        return User::all();
    }

    public function store(Request $request): JsonResponse
    {
        $user = new User($request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|unique:users|max:50',
            'password' =>
                'required|
                regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/|
                min:8|
                confirmed'
        ]));
        $user->save();
        return response()->json($user, 201);
    }

    public function show(User $user): User
    {
        return $user;
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $user->update($request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|unique:users|max:50',
            'password' =>
                'required|
                regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/|
                min:8|
                confirmed'
        ]));
        return response()->json($user, 201);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }

}
