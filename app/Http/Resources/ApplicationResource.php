<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'cover_letter' => $this->cover_letter,
            'resume_url' => $this->resume_path ? asset('storage/'.$this->resume_path) : null,
            'student' => new StudentResource($this->whenLoaded('student')),
            'vacancy' => new VacancyResource($this->whenLoaded('vacancy')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
