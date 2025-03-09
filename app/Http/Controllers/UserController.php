<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('role')->paginate();
        return response()->json($users);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'user_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if ($request->hasFile('user_photo')) {
            $filename = $request->file('user_photo')->store('posts', 'public');
        } else {
            $filename = null;
        }

        $validated['user_photo'] = $filename;
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response()->json($user->load('role'), 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user->load('role'));
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['sometimes', 'string', 'min:8'],
            'user_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'role_id' => ['sometimes', 'exists:roles,id'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if ($request->hasFile('user_photo')) {
            $filename = $request->file('user_photo')->store('posts', 'public');
        } else {
            $filename = null;
        }
        $user->user_photo = $filename;

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        $user->update($validated);
        return response()->json($user->load('role'));
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
