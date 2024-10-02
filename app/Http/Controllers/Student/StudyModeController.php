<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use App\StudyModeHistory;

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
        $questionQuery = $this->question;

        $course = auth()->user()->course;
        
        $data['user_id'] = auth()->id();
        $history = StudyModeHistory::where('user_id', $data['user_id'])
            ->where('subject', html_entity_decode($data['subject']))
            ->where('subtopic', html_entity_decode($data['course']))->first();

        if(@$history->question) {
            $question = @$history->question;
            $question->options = $question->options()->inRandomOrder()->get();
            return response()->json(['question' => $question]);
        }

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
                        ->inRandomOrder()
                        ->first();

        $question->options = $question->options()->inRandomOrder()->get();
        return response()->json(['question' => $question]);
    }

    public function show($id)
    {

    }

    public function edit($id) {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $data['user_id'] = auth()->id();
        $history = StudyModeHistory::where('user_id', $data['user_id'])
            ->where('subject', $data['subject'])
            ->where('subtopic', $data['subtopic'])->first();

        if($history) {
            $history->update([
                'question_id' => $data['question_id'],
            ]);
        } else {
            $history = StudyModeHistory::create([
                'question_id' => $data['question_id'],
                'user_id' => $data['user_id'],
                'subject' => $data['subject'],
                'subtopic' => $data['subtopic'],
            ]);
        }

        return response()->json(['message' => "History saved!"]);
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = auth()->id();
        $history = StudyModeHistory::where('user_id', $data['user_id'])
            ->where('subject', $data['subject'])
            ->where('subtopic', $data['subtopic'])->first();

        if ($history) {
            $history->delete();
        }

        return response()->json(['message' => "History deleted!"]);
    }
}
