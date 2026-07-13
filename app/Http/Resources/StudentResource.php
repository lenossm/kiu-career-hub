<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'faculty' => $this->faculty,
            'short_bio' => $this->short_bio,
            'skills' => $this->skills,
            'experience' => $this->experience,
            'portfolio_link' => $this->portfolio_link,
            'github_link' => $this->github_link,
            'linkedin_link' => $this->linkedin_link,
            'photo_url' => $this->photo_path ? asset('storage/'.$this->photo_path) : null,
            'applications_count' => $this->whenCounted('applications'),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
