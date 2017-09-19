<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| Every route has "/api" as prefix.
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/***    ADMIN CRUD ROUTES    ***/
// TODO: Add auth middleware before accessing them
Route::resource("/admin/questions", "QuestionController");

/***    WEBAPP API ROUTES    ***/
Route::resource("/questions", "ApiQuestionController");
Route::post("/quizzes/create", "ApiQuizController@create");
Route::get("/quizzes/named", "ApiQuizController@indexNamed");
Route::resource("/quizzes", "ApiQuizController");
Route::resource("/answers", "ApiAnswerController");
Route::resource("/courses", "ApiCourseController");
