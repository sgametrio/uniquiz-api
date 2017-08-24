<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	/***  RELATIONSHIPS  ***/

	public function question() {
		return $this->belongsTo(Question::class);
	}
}
