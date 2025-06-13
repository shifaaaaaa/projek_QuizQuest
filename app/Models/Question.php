<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'question', 'correct'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
  
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}

