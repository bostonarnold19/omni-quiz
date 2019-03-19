<?php

namespace App\Http\Controllers\Student;

use App\GroupQuestion;
use App\Http\Controllers\Controller;
use App\UserQuestion;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller {

    public function __construct() {
        $this->user_question = new UserQuestion;
        $this->group_question = new GroupQuestion;
    }

    public function index() {
        //
    }

    public function create(Request $request) {
        $group_question = $this->group_question->find($request->questionnaire_id);
        $user_question = $this->user_question->where('group_question_id', $request->questionnaire_id)->pluck('question_id');
        $questions = $group_question->questions->except($user_question);

        dd($questions);
        return view('modules.questionnaire.create', compact('group_question', 'questions'));
    }

    public function store(Request $request) {
        // $data = $request->all();
        // try {
        //     DB::beginTransaction();
        //     $this->question->save($data);
        //     DB::commit();
        //     $status = 'success';
        //     $message = 'Question has been created.';
        // } catch (\Exception $e) {
        //     $status = 'error';
        //     $message = 'Internal Server Error. Try again later.';
        //     DB::rollBack();
        // }
        // return redirect()->route('questionnaire.index')->with($status, $message);
    }

    public function show($id) {
        //
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
