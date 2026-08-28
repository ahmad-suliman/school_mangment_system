<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'teacher_id'=>$this->teacher_id,
            'name'=>$this->user->name,
            'email'=>$this->user->email,
            'photo_url'      => $this->user->profile_photo
                ? asset('storage/' . $this->user->profile_photo)
                : null,
            'status'=>$this->user->status,
            'phone'=>$this->phone,
            'specialization'=>$this->specialization,
            'hire_date'=>$this->hire_date,
            'address'=>$this->address,
            'created_at'=>$this->created_at->format('Y-m-d'),
            'updated_at'=>$this->updated_at->format('Y-m-d'),
        ];
    }
}
