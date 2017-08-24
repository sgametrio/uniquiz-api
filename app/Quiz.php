<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
	/***  RELATIONSHIPS  ***/

	public function course() {
		return $this->belongsTo(Course::class);
	}

	public function questions() {
		return $this->belongsToMany(Question::class);
	}
}
