<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/find/establishment/' . session('user_id'));
        $establishment = $response->json()['data'];
        $products = $establishment['products'];

        return view('admin.product.ManagementProductsView', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/enable/categories');
        $categories = $response->json()['data'];

        $response = Http::get($url . '/v1/enable/brands');
        $brands = $response->json()['data'];

        return view('admin.product.CreateProduct', [
            'categories' => $categories,
            'brands' => $brands,
            'product' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'name' => 'required|between:3,60',
            'price'  => 'required|integer|between:100,9999999',
            'stock'  => 'required|integer|between:0,1000',
            // 'barcode'  => 'required|integer|unique:products',
            'barcode'  => 'required|integer',
            'section'  => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2040',
            'description'  => 'required',
            'state'  => 'required',
            'category_id'  => 'required',
            'brand_id'  => 'required'
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $response = Http::get($url . '/v1/find/establishment/' . session('user_id'));
        $establishment = $response->json()['data'];

        $response = Http::post($url . '/v1/products', [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'barcode' => $request->barcode,
            'section' => $request->section,
            'image' => $imageName,
            'description' => $request->description,
            'state' => $request->state,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'establishment_id' => $establishment['id']
        ]);

        $request->image->move(public_path('storage/products'), $imageName);

        if ($response->successful()) {
            return redirect()->route('products.index')->with(['success' => 'producto creada']);
        } else {
            return redirect()->route('products.index')->withErrors(['error' => 'no se pudo crear el producto']);
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
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/enable/categories');
        $categories = $response->json()['data'];

        $response = Http::get($url . '/v1/enable/brands');
        $brands = $response->json()['data'];

        $response = Http::get($url . '/v1/products/' . $id);
        $product = $response->json()["data"];

        return view('admin.product.EditProduct', [
            'categories' => $categories,
            'brands' => $brands,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/products/' . $id);
        $product = $response->json()["data"];

        $request->validate([
            'name' => 'required|between:3,60',
            'price'  => 'required|integer|between:100,9999999',
            'stock'  => 'required|integer|between:0,1000',
            // 'barcode'  => 'required|integer|unique:products,barcode,' . $product['id'],
            'barcode'  => 'required|integer',
            'section'  => 'required',
            'image' => 'image|mimes:jpg,png,jpeg|max:2040',
            'description'  => 'required',
            'state'  => 'required',
            'category_id'  => 'required',
            'brand_id'  => 'required'
        ]);

        $response = Http::get($url . '/v1/find/establishment/' . session('user_id'));
        $establishment = $response->json()['data'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();

            if ($product['image'] && $product['image'] != 'default.svg' && File::exists(public_path('storage/products/' . $product['image']))) {
                File::delete(public_path('storage/products/' . $product['image']));
            }

            $request->image->move(public_path('storage/products'), $imageName);

            $response = Http::put($url . '/v1/products/' . $id, [
                'image' => $imageName
            ]);
        }

        $response = Http::put($url . '/v1/products/' . $id, [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'barcode' => $request->barcode,
            'section' => $request->section,
            'description' => $request->description,
            'state' => $request->state,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'establishment_id' => $establishment['id']
        ]);

        if ($response->successful()) {
            return redirect()->route('products.index')->with(['success' => 'producto actualizado']);
        } else {
            return redirect()->route('products.index')->withErrors(['error' => 'no se pudo actualizar el producto']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/products/' . $id);
        $product = $response->json()["data"];

        if ($product['image'] && $product['image'] != 'default.svg' && File::exists(public_path('storage/products/' . $product['image']))) {
            File::delete(public_path('storage/products/' . $product['image']));
        }

        $response = Http::delete($url . '/v1/products/' . $id);

        if ($response->successful()) {
            return redirect()->route('products.index')->with(['success' => 'producto eliminado']);
        } else {
            return redirect()->route('products.index')->withErrors(['error' => 'no se pudo eliminar el producto']);
        }
    }
}
