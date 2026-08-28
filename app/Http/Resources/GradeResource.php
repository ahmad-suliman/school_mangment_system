<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'marks'   => $this->marks,
            'subject' => $this->whenLoaded('subject', fn () => [
                'id'   => $this->subject->id,
                'subject_name' => $this->subject->subject_name,
                'subject_code' => $this->subject->subject_code,
            ]),
            'student' => $this->whenLoaded('student', fn () => [
                'id'   => $this->student->id,
                'name' => $this->student->user->name ?? null,
            ]),
            'teacher' => $this->whenLoaded('teacher', fn () => [
                'id'   => $this->teacher->id,
                'name' => $this->teacher->user->name ?? null,
            ]),
            'created_at' => $this->created_at?->format('Y-m-d'),
        ];
    }
}
