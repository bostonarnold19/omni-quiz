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

    public function index()
    {
        return view('modules.study_mode.index');
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $questionQuery = $this->question->with('options');

        if (@$data['question_ids']) {
            $questionQuery->whereNotIn('id', @$data['question_ids']);
        }

        $question = $questionQuery->inRandomOrder()->first();
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
