<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'department',
        'bio',
        'photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(ProfessorApplication::class);
    }

    public function vacancies()
    {
        return $this->belongsToMany(Vacancy::class, 'professor_applications')
            ->withPivot('cover_letter', 'status', 'resume_path')
            ->withTimestamps();
    }
}
