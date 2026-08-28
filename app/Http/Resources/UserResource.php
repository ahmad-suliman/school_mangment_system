<?php

namespace App\Http\Resources;

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
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'profile_photo' => $this->profile_photo ? asset('storage/' . $this->profile_photo) : null,
            'status'        => $this->status,
            'created_at'    => $this->created_at->format('Y-m-d H:m:s'),
            'roles'         => $this->getRoleNames(), // if using Spatie
            'teacher'       => $this->whenLoaded('teacher'),
            'student'       => $this->whenLoaded('student', function () {
                return [
                    'id'        => $this->student->id,
                    'classroom' => $this->student->classroom?->class_name,
                ];
            }),
        ];
    }
}
