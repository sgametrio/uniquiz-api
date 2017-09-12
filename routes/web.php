<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Question;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Answer;

Route::get("/", function () {
    return "It works! (laravel)";
});

Route::get("/questions", function () {
    return Question::all();
});

Route::get("/questions/{question}", function (Question $question) {
    // Example of dinamically hiding fields
    //$question->makeHidden("created_at");
    return $question;
});

Route::get("/answers", function () {
    return Answer::all();
});

Route::get("/answers/{answer}", function (Answer $answer) {
    // Returning answer with its question
    return $answer->with("question")->get();
});
