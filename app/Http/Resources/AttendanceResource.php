<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'date'   => $this->date,
            'status' => $this->status,
            'student' => $this->whenLoaded('student', fn () => [
                'id'   => $this->student->id,
                'name' => $this->student->user->name ?? null,
            ]),
            'subject' => $this->whenLoaded('subject', fn () => [
                'id'   => $this->subject->id,
                'name' => $this->subject->subject_name,
            ]),
            'teacher' => $this->whenLoaded('teacher', fn () => [
                'id'   => $this->teacher->id,
                'name' => $this->teacher->user->name ?? null,
            ]),
        ];
    }
}
