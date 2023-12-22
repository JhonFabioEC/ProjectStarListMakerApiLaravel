<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstablishmentResource extends JsonResource
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
            'phone_number' => $this->phone_number,
            'zone_type' => $this->zone_type,
            'address' => $this->address,
            'user' => [
                'id' => $this->user->id,
                'image' => $this->user->image,
                'username' => $this->user->username,
                'password' => $this->user->password,
                'email_address' => $this->user->email_address,
                'account_status' => $this->user->account_status,
                'roleType' => [
                    'id' => $this->user->roleType->id,
                    'name' => $this->user->roleType->name,
                    'color' => $this->user->roleType->color
                ]
            ],
            'municipality' => [
                'id' => $this->municipality->id,
                'name' => $this->municipality->name,
                'department' => [
                    'id' => $this->municipality->department->id,
                    'name' => $this->municipality->department->name
                ]
            ],
            'establishmentType' => [
                'id' => $this->establishmentType->id,
                'name' => $this->establishmentType->name
            ],
            'products' => ProductResource::collection($this->products)
        ];
    }
}
