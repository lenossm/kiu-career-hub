<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessorApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'vacancy_id',
        'cover_letter',
        'resume_path',
        'status',
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
