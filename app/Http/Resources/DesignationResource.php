<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
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
            'type' => $this->type,
            'user' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
            ],
            'college' => $this->college->name ?? null,
            'image_url' => $this->image ?? null,
        ];
    }
}
