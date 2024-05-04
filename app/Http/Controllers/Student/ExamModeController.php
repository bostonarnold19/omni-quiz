<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\QuestionnaireCode;

class ExamModeController extends Controller
{
    public function __construct()
    {
        $this->question = new Question;
        $this->questionnaire_code = new QuestionnaireCode;
    }

    public function index()
    {
        $user = auth()->user();

        $questionnaire_code = $this->questionnaire_code->where('user_id', $user->id)
            ->where(function($query) {
                $query->where('time_start', '<=',date('Y-m-d H:i:s'))
                ->where('time_end', '>=',date('Y-m-d H:i:s'))
                ->orWhereNull('time_start')
                ->orWhereNull('time_end');
            })->whereNull('result')->first();
        if (!$questionnaire_code) {
            return redirect(url('/dashboard'));
        }
        return view('modules.exam_mode.index', compact('questionnaire_code'));
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
