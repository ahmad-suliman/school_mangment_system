<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'             => $this->id,
            'student_id'     => $this->student_id,
            'name'           => $this->user->name ?? null,
            'email'          => $this->user->email ?? null,
            'status'         => $this->user->status,
            'phone'          => $this->phone,
            'birth_date'     => $this->birth_date,
            'address'        => $this->address,
            'guardian_name'  => $this->guardian_name,
            'guardian_phone' => $this->guardian_phone,
            'photo_url'      => $this->user->profile_photo
                ? asset('storage/' . $this->user->profile_photo)
                : null,
            'classroom'      => $this->whenLoaded('classroom', fn () => [
                'id'      => $this->classroom->id,
                'name'    => $this->classroom->class_name,
                'section' => $this->classroom->section,
            ]),
        ];;
    }
}
