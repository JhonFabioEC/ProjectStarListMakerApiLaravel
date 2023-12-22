<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\EstablishmentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EstablishmentTypeResource;

class EstablishmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $establishmentTypes = EstablishmentType::get();
        return EstablishmentTypeResource::collection($establishmentTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $establishmentType = new EstablishmentType();
        $establishmentType->name = $request->input('name');
        $establishmentType->state = $request->input('state');

        $establishmentType->save();

        return response()->json([
            'message' => 'El tipo de establecimiento ha sido creado',
            'data' => $establishmentType
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(EstablishmentType $establishmentType)
    {
        return new EstablishmentTypeResource($establishmentType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstablishmentType $establishmentType)
    {
        $establishmentType->update($request->all());

        return response()->json([
            'message' => 'El tipo de establecimiento ha sido actualizado',
            'data' => $establishmentType
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstablishmentType $establishmentType)
    {
        $establishmentType->delete();

        return response()->json([
            'message' => 'El tipo de establecimiento ha sido eliminado'
        ], Response::HTTP_ACCEPTED);
    }

    public function getEnableEstablishmentTypes()
    {
        $establishmentTypes = EstablishmentType::where('state', true)->get();
        return EstablishmentTypeResource::collection($establishmentTypes);
    }
}
