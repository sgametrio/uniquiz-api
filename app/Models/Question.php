<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;

class Question extends Model
{
    use Uuids;

    /**
    * Indicates if the IDs are auto-incrementing.
    *
    * @var bool
    */
    public $incrementing = false;

    // Unprotect from Mass Assignment
    protected $guarded = [];

    /***  RELATIONSHIPS  ***/

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
