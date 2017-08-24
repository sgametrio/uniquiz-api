<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
	/**
		* Run the migrations.
		*
		* @return void
		*/
	public function up()
	{
		Schema::create("question_quiz", function (Blueprint $table) {
			$table->integer("question_id")->unsigned();
			$table->integer("quiz_id")->unsigned();

			$table->foreign("question_id")->references("id")->on("questions");
			$table->foreign("quiz_id")->references("id")->on("quizzes");

			$table->primary(["question_id", "quiz_id"]);
		});

		Schema::table("answers", function (Blueprint $table) {
			$table->integer("question_id")->unsigned();
			$table->foreign("question_id")->references("id")->on("questions");
		});

		Schema::table("quizzes", function (Blueprint $table) {
			$table->integer("course_id")->unsigned();
			$table->foreign("course_id")->references("id")->on("courses");
		});
	}

	/**
		* Reverse the migrations.
		*
		* @return void
		*/
	public function down()
	{
		Schema::dropIfExists("question_quiz");

		Schema::table("answers", function (Blueprint $table) {
			$table->dropForeign(["question_id"]);
		});

		Schema::table("quizzes", function (Blueprint $table) {
			$table->dropForeign(["course_id"]);
		});
	}
}
