<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'id'           => $this->id,
            'title'        => $this->title,
            'message'      => $this->message,
            'target_role'  => $this->target_role,
            'published_at' => $this->published_at,
        ];
    }
}
