<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	/***  RELATIONSHIPS  ***/

	public function question() {
		return $this->belongsTo(Question::class);
	}
}
