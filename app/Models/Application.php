<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'vacancy_id',
        'cover_letter',
        'resume_path',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}

