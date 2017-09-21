<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;

class Quiz extends Model
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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
