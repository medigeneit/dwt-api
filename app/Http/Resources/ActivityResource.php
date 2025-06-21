<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ActivityResource extends JsonResource
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
            'category' => $this->category,
            'slug'  => Str::slug($this->title), // ✅ slug তৈরি হচ্ছে এখানেই
            'description' => $this->description,
            'location' => $this->location,
            'activity_date' => $this->activity_date ?? null,
            'photo' => $this->photo ?? null,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
