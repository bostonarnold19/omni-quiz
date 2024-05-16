<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;

class StudyModeController extends Controller
{

    public function __construct()
    {
        $this->question = new Question;
        // $this->questionnaire_code = new QuestionnaireCode;
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $subjects = explode(" | ", @$data['select_subject']);
        $data['subject'] = @$subjects[0];
        $data['course'] = @$subjects[1];
        return view('modules.study_mode.index', compact('data'));
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $questionQuery = $this->question->with('options');

        $course = auth()->user()->course;

        if (@$data['question_ids']) {
            $questionQuery->whereNotIn('id', @$data['question_ids']);
        }

        if (@$data['subject']) {
            $questionQuery->where('subject', @$data['subject']);
        }

        if (@$data['subtopic']) {
            $questionQuery->where('course', @$data['subtopic']);
        }

        $question = $questionQuery
                        ->where('course', $course)
                        ->inRandomOrder()->first();
        return response()->json(['question' => $question]);
    }

    public function show($id)
    {

    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        //
    }
}
