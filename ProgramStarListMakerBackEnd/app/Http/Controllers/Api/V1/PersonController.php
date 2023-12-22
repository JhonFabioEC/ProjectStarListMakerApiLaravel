<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PersonResource;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $persons = Person::get();
        return PersonResource::collection($persons);
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
    public function show(Person $person)
    {
        return new PersonResource($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $user = User::find($person->user_id);

        $user->update($request->all());
        $person->update($request->all());

        return response()->json([
            'message' => 'Person updated',
            'data' => $person
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $user = User::find($person->user_id);
        $user->delete();

        return response()->json([
            'message' => 'Person deleted'
        ], Response::HTTP_ACCEPTED);
    }
}
