<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\RoleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RoleTypeResource;

class RoleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleTypes = RoleType::get();
        return RoleTypeResource::collection($roleTypes);
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
    public function show(RoleType $roleType)
    {
        return new RoleTypeResource($roleType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleType $roleType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleType $roleType)
    {
        //
    }
}
