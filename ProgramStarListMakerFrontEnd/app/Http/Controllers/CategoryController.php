<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/categories');
        $categories = $response->json()['data'];

        return view('admin.category.ManagementCategoriesView', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.CreateCategories', ['category' => null]);
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

        $response = Http::post($url . '/v1/categories', [
            'name' => $request->name,
            'state' => $request->state
        ]);

        if ($response->successful()) {
            return redirect()->route('categories.index')->with(['success' => 'categoría creada']);
        } else {
            return redirect()->route('categories.index')->withErrors(['error' => 'no se pudo crear la categoría']);
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
        $response = Http::get($url . '/v1/categories/' . $id);
        $category = $response->json()["data"];

        return view('admin.category.EditCategories', ['category' => $category]);
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

        $response = Http::put($url . '/v1/categories/' . $id, [
            'name' => $request->name,
            'state' => $request->state
        ]);

        if ($response->successful()) {
            return redirect()->route('categories.index')->with(['success' => 'categoría actualizada']);
        } else {
            return redirect()->route('categories.index')->withErrors(['error' => 'no se pudo actualizar la categoría']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::delete($url . '/v1/categories/' . $id);

        if ($response->successful()) {
            return redirect()->route('categories.index')->with(['success' => 'categoría eliminada']);
        } else {
            return redirect()->route('categories.index')->withErrors(['error' => 'no se pudo eliminar la categoría']);
        }
    }
}
