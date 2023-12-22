<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/brands');
        $brands = $response->json()['data'];

        return view('admin.brand.ManagementBrandsView', ['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.CreateBrands', ['brand' => null]);
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

        $response = Http::post($url . '/v1/brands', [
            'name' => $request->name,
            'state' => $request->state
        ]);


        if ($response->successful()) {
            return redirect()->route('brands.index')->with(['success' => 'marca creada']);
        } else {
            return redirect()->route('brands.index')->withErrors(['error' => 'no pudo crear la marca']);
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
        $response = Http::get($url . '/v1/brands/' . $id);
        $brand = $response->json()["data"];

        return view('admin.brand.EditBrands', ['brand' => $brand]);
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

        $response = Http::put($url . '/v1/brands/' . $id, [
            'name' => $request->name,
            'state' => $request->state
        ]);

        if ($response->successful()) {
            return redirect()->route('brands.index')->with(['success' => 'marca actualizada']);
        } else {
            return redirect()->route('brands.index')->withErrors(['error' => 'no se pudo actualizar la marca']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::delete($url . '/v1/brands/' . $id);

        if ($response->successful()) {
            return redirect()->route('brands.index')->with(['success' => 'marca eliminada']);
        } else {
            return redirect()->route('brands.index')->withErrors(['error' => 'no se pudo eliminar la marca']);
        }
    }
}
