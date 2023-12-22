<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemOrderResource extends JsonResource
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
            'quantity' => $this->quantity,
            'barcode' => $this->barcode,
            'image' => $this->image,
            'category' => $this->category,
            'brand' => $this->brand,
            'establishment' => $this->establishment,
            'person' => [
                'id' => $this->person->id,
                'first_name' => $this->person->first_name,
                'last_name' => $this->person->last_name
            ]
        ];
    }
}
