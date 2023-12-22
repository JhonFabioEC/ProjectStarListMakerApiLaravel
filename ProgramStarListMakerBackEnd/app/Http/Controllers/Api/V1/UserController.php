<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function findUser($id)
    {
        $users = User::where('id', '!=', $id)->get();
        return UserResource::collection($users);
    }

    public function setAccountStatus($id)
    {
        $user = User::find($id);
        $user->account_status = !$user->account_status;
        $user->update();

        return response()->json([
            'message' => 'El estado de la cuenta de ha sido actualizada',
            'data' => $user
        ], Response::HTTP_ACCEPTED);
    }
}
