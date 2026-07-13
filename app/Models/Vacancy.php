<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    /** @use HasFactory<\Database\Factories\VacancyFactory> */
    use HasFactory;

    public const AUDIENCE_STUDENT = 'student';
    public const AUDIENCE_PROFESSOR = 'professor';

    protected $fillable = [
        'title',
        'company',
        'description',
        'required_skills',
        'location',
        'type',
        'audience',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeForStudents(Builder $query): Builder
    {
        return $query->where('audience', self::AUDIENCE_STUDENT);
    }

    public function scopeForProfessors(Builder $query): Builder
    {
        return $query->where('audience', self::AUDIENCE_PROFESSOR);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function professorApplications()
    {
        return $this->hasMany(ProfessorApplication::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'applications')
            ->withPivot('cover_letter', 'status', 'resume_path')
            ->withTimestamps();
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_applications')
            ->withPivot('cover_letter', 'status', 'resume_path')
            ->withTimestamps();
    }

    public function isForStudents(): bool
    {
        return $this->audience === self::AUDIENCE_STUDENT;
    }

    public function isForProfessors(): bool
    {
        return $this->audience === self::AUDIENCE_PROFESSOR;
    }
}
