<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'barcode' => $this->barcode,
            'section' => $this->section,
            'image' => $this->image,
            'description' => $this->description,
            'state' => $this->state,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'state' => $this->category->state
            ],
            'brand' => [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
                'state' => $this->brand->state
            ],
            'establishment' => [
                'id' => $this->establishment->id,
                'name' => $this->establishment->name
            ]
        ];
    }
}
