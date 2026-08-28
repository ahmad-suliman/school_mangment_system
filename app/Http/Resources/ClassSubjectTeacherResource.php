<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassSubjectTeacherResource extends JsonResource
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
            'classroom' => $this->whenLoaded('classroom', fn () => [
                'id'      => $this->classroom->id,
                'name'    => $this->classroom->class_name,
                'section' => $this->classroom->section,
            ]),
            'subject' => $this->whenLoaded('subject', fn () => [
                'id'   => $this->subject->id,
                'name' => $this->subject->subject_name,
                'code' => $this->subject->subject_code,
            ]),
            'teacher' => $this->whenLoaded('teacher', fn () => [
                'id'   => $this->teacher->id,
                'name' => $this->teacher->user->name ?? null,
            ]),
            'created_at' => $this->created_at?->format('Y-m-d H:m:s'),
        ];
    }
}
