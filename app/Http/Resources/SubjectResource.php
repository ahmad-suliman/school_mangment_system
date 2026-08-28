<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'subject_name'  => $this->subject_name,
            'subject_code'  => $this->subject_code,
            'created_at'    => $this->created_at->format('Y-m-d'),
            'updated_at'    => $this->updated_at->format('Y-m-d'),
        ];
    }
}
