<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'correct_answers',
        'answers',
        'time_taken',
        'completed_at'
    ];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getScorePercentageAttribute()
    {
        return $this->total_questions > 0 ? round(($this->correct_answers / $this->total_questions) * 100, 2) : 0;
    }
}
