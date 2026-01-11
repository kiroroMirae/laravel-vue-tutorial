<?php

namespace App\Http\Controllers;

use App\Actions\UserAction;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index')->with(['sanctum_token' => session('auth_token')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('user.create')->with(['sanctum_token' => session('auth_token')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $data = UserAction::createUser($request->post());

            return response()->json(['message' => 'User created successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit')->with(['user' => $user, 'sanctum_token' => session('auth_token')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            ]);

            $data = UserAction::updateUser($request->post(), $user);
            return response()->json(['message' => 'User updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 422);
        }
    }


    public function getUserList(Request $request) {
        $data = UserAction::getUserList($request->post());
        return $data;
    }
}
