<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ItemOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ItemOrderResource;

class ItemOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemOrders = ItemOrder::get();
        return ItemOrderResource::collection($itemOrders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $itemOrder = new ItemOrder();
        $itemOrder->name = $request->input('name');
        $itemOrder->price = $request->input('price');
        $itemOrder->quantity = $request->input('quantity');
        $itemOrder->barcode = $request->input('barcode');
        $itemOrder->image = $request->input('image');
        $itemOrder->category = $request->input('category');
        $itemOrder->brand = $request->input('brand');
        $itemOrder->establishment = $request->input('establishment');
        $itemOrder->person_id = $request->input('person_id');

        $itemOrder->save();

        return response()->json([
            'message' => 'El producto ha sido añadido',
            'data' => $itemOrder
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemOrder $itemOrder)
    {
        return new ItemOrderResource($itemOrder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemOrder $itemOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemOrder $itemOrder)
    {
        $itemOrder->delete();

        return response()->json([
            'message' => 'El producto ha sido quitado'
        ], Response::HTTP_ACCEPTED);
    }
}
