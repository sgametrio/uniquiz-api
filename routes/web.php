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

/***    CRUD ADMIN ROUTES    ***/
// TODO: add auth middleware
Route::resource("/questions", "QuestionController");
Route::resource("/quizzes", "QuizController");
Route::resource("/answers", "AnswerController");
Route::resource("/courses", "CourseController");

/***    API ROUTES FOR WEB APP    ***/
//Route::resource("/api/questions", "ApiQuestionController");
Route::resource("/api/quizzes", "ApiQuizController");
Route::resource("/api/answers", "ApiAnswerController");
Route::resource("/api/courses", "ApiCourseController");
