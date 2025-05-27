<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'    => $this->id,
            'title' => $this->title,
            'slug'  => Str::slug($this->title),
            'photo' => $this->photo ?? null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
