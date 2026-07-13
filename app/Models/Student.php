<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'faculty',
        'short_bio',
        'skills',
        'experience',
        'portfolio_link',
        'github_link',
        'linkedin_link',
        'photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function vacancies()
    {
        return $this->belongsToMany(Vacancy::class, 'applications')
            ->withPivot('cover_letter', 'status', 'resume_path')
            ->withTimestamps();
    }
}
