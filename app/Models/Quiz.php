<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['title', 'description', 'min_level',]; 
 
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}