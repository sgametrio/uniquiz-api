<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Question;
use App\Http\Resources\Course as CourseResource;
use Illuminate\Http\Request;

class ApiCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CourseResource::collection(Course::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "code" => "required"
        ]);

        $course = Course::create([
            "name" => $request->name,
            "code" => $request->code
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return new CourseResource($course);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }

    public function importCourse(Request $request) {
        // TODO: better args validation
        // * course.name ecc...
        $request->validate([
            "course" => "required",
            "course.name" => "required",
            "course.code" => "required"
        ]);

        // For now, we accept a course with questions as a direct child and
        // course with chapters with questions

        return DB::transaction(function () use ($request) {

            $coursePost = $request->course;
            $questions = [];

            // Need to find something for categorizing chapters questions
            if (array_key_exists("chapters", $coursePost)) {
                // For now, extract questions all together
                foreach ($coursePost["chapters"] as $chapter) {
                    $questions = array_merge($questions, $chapter["questions"]);
                }
            } else {
                $questions = $coursePost["questions"];
            }

            // DB OPERATIONS
            $course = Course::firstOrCreate([
                "name" => $coursePost["name"],
                "code" => $coursePost["code"]
            ]);

            foreach ($questions as $question) {
                $courseQuestion = Question::create([
                    "text" => $question["text"],
                    "solution_type" => $question["solution_type"],
                    "course_id" => $course["id"]
                ]);
                $courseQuestion->answers()->createMany($question["answers"]);
            }
        });
    }
}
