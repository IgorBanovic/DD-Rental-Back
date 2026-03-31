<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{

    public function index()
    {
        return new UserCollection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user, UserService $userService)
    {
     try{
             $userService->update($user);
             return new UserResource($user);
        }  catch(Exception $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
     }
    }

    public function destroy(User $user, UserService $userService): JsonResponse
    {
        try {
            $userService->destroy($user);
            return response()->json('User successfully deleted');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

}
