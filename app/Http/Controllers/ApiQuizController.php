<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Course;
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
    public function named(Course $course = null)
    {
        if ($course == null)
            return QuizResource::collection(Quiz::whereNotNull("name")->get());
        return QuizResource::collection($course->quizzes()->whereNotNull("name")->get());
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

        return DB::transaction(function () use ($request) {
            //TODO: Add control over numberOfQuestions and questions existing in DB
            $questions = Question::where("course_id", "=", $request->courseId)->inRandomOrder()->take($request->numberOfQuestions)->get()->pluck("id");
            $quiz = Quiz::create([
                "course_id" => $request->courseId
            ]);
            $quiz->questions()->attach($questions->toArray());

            return new QuizResource($quiz);
        });
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

        DB::transaction(function () use ($request) {
            //TODO: Verify that all questionIds exists and belong to the same courseId
            $quiz = Quiz::create([
                "course_id" => $request->courseId,
                "name" => $request->quizName
            ]);
            $quiz->questions()->attach($request->questionIds);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        return new QuizResource($quiz);
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
     * Return a score of user submission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkSubmission(Request $request)
    {
        $quizSubmission = $request->submission;
        $maxScore = 0;
        $score = 0;
        // For every correct answer 1 point (maybe this has to be saved on DB)
        $quiz = Quiz::find($quizSubmission["id"]);
        foreach ($quizSubmission["questions"] as $question) {
            // Check if question exists into DB
            $correctQuestion = Question::findOrFail($question["id"]);
            // Check answer and calculate score based on solution_type
            if ($correctQuestion->solution_type === "single") {
                $maxScore += 1;
                $answer = $correctQuestion->answers->where("correct", "=", true)->first();
                if ($question["answerId"] === $answer["id"]) {
                    // Congrats, correct answer, +1!
                    $score += 1;
                }
            } else if ($correctQuestion->solution_type === "open") {
                $maxScore += 1;
                $answer = $correctQuestion->answers->where("correct", true)->first();
                if ($question["openAnswerText"] === $answer["text"]) {
                    // Congrats, correct answer, +1!
                    $score += 1;
                }
            } else {
                // Check for multiple correct answers
                // Don't know if pluck mess up things or not
                // Change scoring method because if all answers are checked -> max score
                $answersIds = $correctQuestion->answers->where("correct", true)->get()->pluck("id");
                foreach ($answersIds as $correctId) {
                    $maxScore += 1;
                    if (in_array($correctId, $question["answersIds"])) {
                        // Congrats, correct answer, +1!
                        $score += 1;
                    }
                }
            }
        }

        $scoreObj = [
            "score" => $score,
            "maxScore" => $maxScore
        ];

        return $scoreObj;
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
