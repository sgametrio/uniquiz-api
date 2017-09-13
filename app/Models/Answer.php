<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    /***  RELATIONSHIPS  ***/

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
