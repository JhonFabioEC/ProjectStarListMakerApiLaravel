<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->barcode = $request->input('barcode');
        $product->section = $request->input('section');
        $product->image = $request->input('image');
        $product->description = $request->input('description');
        $product->state = $request->input('state');
        $product->category_id = $request->input('category_id');
        $product->brand_id = $request->input('brand_id');
        $product->establishment_id = $request->input('establishment_id');

        $product->save();

        return response()->json([
            'message' => 'El producto ha sido creado',
            'data' => $product
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response()->json([
            'message' => 'El producto ha sido actualizado',
            'data' => $product
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'El producto ha sido eliminado'
        ], Response::HTTP_ACCEPTED);
    }

    public function getEnableProducts()
    {
        $products = Product::where('state', true)
            ->whereHas('category', function ($query) {
                $query->where('state', true);
            })
            ->whereHas('brand', function ($query) {
                $query->where('state', true);
            })->get();

        return ProductResource::collection($products);
    }

    public function getProductsByName(Request $request)
    {
        $products = Product::where('state', true)
            ->where('name', 'like', '%' . $request->search . '%')
            ->whereHas('category', function ($query) {
                $query->where('state', true);
            })
            ->whereHas('brand', function ($query) {
                $query->where('state', true);
            })->get();

        return ProductResource::collection($products);
    }
}
