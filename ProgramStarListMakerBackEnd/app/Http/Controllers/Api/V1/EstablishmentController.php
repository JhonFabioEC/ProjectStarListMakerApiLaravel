<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EstablishmentResource;

class EstablishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $establishments = Establishment::get();
        return EstablishmentResource::collection($establishments);
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
    public function show(Establishment $establishment)
    {
        return new EstablishmentResource($establishment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Establishment $establishment)
    {
        $user = User::find($establishment->user_id);

        $user->update($request->all());
        $establishment->update($request->all());

        return response()->json([
            'message' => 'Establishment updated',
            'data' => $establishment
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Establishment $establishment)
    {
        $user = User::find($establishment->user_id);
        $user->delete();

        return response()->json([
            'message' => 'Establishment deleted'
        ], Response::HTTP_ACCEPTED);
    }

    public function findEstablishment(int $id)
    {
        $establishment = Establishment::where('user_id', $id)->get();
        return new EstablishmentResource($establishment[0]);
    }
}
