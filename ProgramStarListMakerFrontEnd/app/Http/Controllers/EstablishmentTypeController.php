<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EstablishmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/establishment_types');
        $establishmentTypes = $response->json()['data'];

        return view('admin.establishmentType.ManagementEstablishmentTypesView', ['establishmentTypes' => $establishmentTypes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.establishmentType.CreateEstablishmentType', ['establishmentType' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'name' => 'required|between:3,60',
            'state' => 'required'
        ]);

        $response = Http::post($url . '/v1/establishment_types', [
            'name' => $request->name,
            'state' => $request->state
        ]);

        if ($response->successful()) {
            return redirect()->route('establishment_types.index')->with(['success' => 'tipo de establecimiento creado']);
        } else {
            return redirect()->route('establishment_types.index')->withErrors(['error' => 'no se pudo crear el tipo de establecimiento']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::get($url . '/v1/establishment_types/' . $id);
        $establishmentType = $response->json()["data"];

        return view('admin.establishmentType.EditEstablishmentType', ['establishmentType' => $establishmentType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'name' => 'required|between:3,60',
            'state' => 'required'
        ]);

        $response = Http::put($url . '/v1/establishment_types/' . $id, [
            'name' => $request->name,
            'state' => $request->state
        ]);

        if ($response->successful()) {
            return redirect()->route('establishment_types.index')->with(['success' => 'tipo de establecimiento actualizado']);
        } else {
            return redirect()->route('establishment_types.index')->withErrors(['error' => 'no se pudo actualizar el tipo de establecimiento']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::delete($url . '/v1/establishment_types/' . $id);

        if ($response->successful()) {
            return redirect()->route('establishment_types.index')->with(['success' => 'tipo de establecimiento eliminado']);
        } else {
            return redirect()->route('establishment_types.index')->withErrors(['error' => 'no se pudo eliminar el tipo de establecimiento']);
        }
    }
}
