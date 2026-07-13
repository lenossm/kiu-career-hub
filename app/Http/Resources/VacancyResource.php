<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'company' => $this->company,
            'description' => $this->description,
            'required_skills' => $this->required_skills,
            'location' => $this->location,
            'type' => $this->type,
            'status' => $this->status,
            'audience' => $this->audience,
            'deadline' => $this->deadline?->format('Y-m-d'),
            'applications_count' => $this->whenCounted('applications'),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
