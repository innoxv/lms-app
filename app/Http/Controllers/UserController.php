<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function show(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $user = user::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function destroy(string $id): JsonResponse
    {
        User::destroy($id);
        return response()->json(null, 204);
    }
}