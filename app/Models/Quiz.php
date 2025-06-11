<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The users that have completed this quiz.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'quiz_user')->withTimestamps();
    }
}