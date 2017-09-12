<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Example of hiding useless info
    //protected $hidden = ["created_at", "updated_at"];

    /***  RELATIONSHIPS  ***/

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }
}
