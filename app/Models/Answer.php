<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Uuids;

class Answer extends Model
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

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
