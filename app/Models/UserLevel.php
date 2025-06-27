<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'level', 'xp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

