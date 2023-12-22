<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'image' => $this->image,
            'username' => $this->username,
            'email_address' => $this->email_address,
            'account_status' => $this->account_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roleType' => [
                'id' => $this->roleType->id,
                'name' => $this->roleType->name,
                'color' => $this->roleType->color
            ],
            'persons' => $this->persons ? PersonResource::collection($this->persons) : null,
            'establishments' => $this->establishments ? EstablishmentResource::collection($this->establishments) : null
        ];
    }
}
