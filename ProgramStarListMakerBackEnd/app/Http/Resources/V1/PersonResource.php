<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'sex' => $this->sex,
            'document_number' => $this->document_number,
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
            'documentType' => [
                'id' => $this->documentType->id,
                'name' => $this->documentType->name
            ],
            'municipality' => [
                'id' => $this->municipality->id,
                'name' => $this->municipality->name,
                'department' => [
                    'id' => $this->municipality->department->id,
                    'name' => $this->municipality->department->name
                ]
            ],
            'itemOrders' => $this->itemOrders ? ItemOrderResource::collection($this->itemOrders) : null
        ];
    }
}
