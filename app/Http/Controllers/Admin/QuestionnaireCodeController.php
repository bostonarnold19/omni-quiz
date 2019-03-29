<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Question;
use App\Questionnaire;
use App\QuestionnaireCode;
use App\QuestionOption;
use DB;
use Illuminate\Http\Request;

class QuestionnaireCodeController extends Controller {

    public function __construct() {
        $this->group_question = new Questionnaire;
        $this->question = new Question;
        $this->answer = new Answer;
        $this->question_option = new QuestionOption;
        $this->questionnaire_code = new QuestionnaireCode;
        $this->middleware('permission:codes', ['only' => ['store']]);

    }

    public function index() {
    }

    public function create() {
    }

    public function store(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $questionnaire_code = $this->questionnaire_code->create($data);

            $questions = $questionnaire_code->questionnaire->questions()->inRandomOrder()->get();

            foreach ($questions as $q) {
                $data = [
                    'user_id' => $questionnaire_code->user_id,
                    'question_id' => $q->id,
                    'questionnaire_code_id' => $questionnaire_code->id,
                ];
                $answer = $this->answer->create($data);
            }

            DB::commit();
            $status = 'success';
            $message = 'Group Question has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->back()->with($status, $message);
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $group_question = $this->group_questions->find($id);
        return view('modules.group_question.edit', compact('group_question'));
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $data['time'] = $data['minute'] . ":" . $data['second'];
        try {
            DB::beginTransaction();
            $group_q = $this->group_question->find($data['id']);
            if (isset($data['is_published'])) {
                $data['is_published'] = 1;
            } else {
                $data['is_published'] = null;
            }

            $group_q->fill($data);
            $group_q->save();

            DB::commit();
            $status = 'success';
            $message = 'Group Question has been updated.';
        } catch (\Exception $e) {

            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('group-question.index')->with($status, $message);
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $group_q = $this->group_question->find($id);
            $group_q->questions()->detach();
            $this->group_question->destroy($id);
            $status = 'success';
            $message = 'Group Question has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('group-question.index')->with($status, $message);
    }

    private function parseSubjects($questions) {
        if (empty($questions)) {
            return [];
        }
        $datas = [];
        foreach ($questions as $key => $value) {
            if (in_array($value->subject . " | " . $value->course, $datas)) {
                continue;
            }
            $datas[] = $value->subject . " | " . $value->course;
        }
        return $datas;
    }
}
