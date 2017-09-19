<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Http\Resources\Quiz as QuizResource;
use App\Http\Resources\Question as QuestionResource;
use Illuminate\Http\Request;

class ApiQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuizResource::collection(Quiz::all());
    }

    /**
     * Display only named quiz.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexNamed()
     {
         return QuizResource::collection(Quiz::whereNotNull("name")->get());
     }

    /**
     * Apply some additional steps before storing newly random-created quiz.
     * This route is intended to be POSTed via HTTP,
     * not GETed like the standard way.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            "numberOfQuestions" => "required",
            "courseId" => "required"
        ]);

        $questions = Question::where("course_id", "=", $request->courseId)->inRandomOrder()->take($request->numberOfQuestions)->get()->pluck("id");
        $quiz = Quiz::create([
            "course_id" => $request->courseId
        ]);
        $quiz->questions()->attach($questions->toArray());
        return new QuizResource($quiz);
    }

    /**
     * Store a newly created named quiz.
     *
     * @param  \Illuminate\Http\Request  $request
     *      $request->quizName
     *      $request->courseId
     *      $request->questionIds
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "quizName" => "required",
            "courseId" => "required",
            "questionIds" => [
                "array",
                "required"
            ]
        ]);

        //TODO: Verify that all questionIds exists and belong to the same courseId
        $quiz = Quiz::create([
            "course_id" => $request->courseId,
            "name" => $request->quizName
        ]);
        $quiz->questions()->attach($request->questionIds);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new QuizResource(Quiz::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
