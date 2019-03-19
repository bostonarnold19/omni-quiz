<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\UserQuestion;
use DB;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller {

    public function __construct() {
        $this->user_questions = new UserQuestion;
    }

    public function index() {
        //
    }

    public function create() {
        return view('modules.questionnaire.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $this->question->save($data);
            DB::commit();
            $status = 'success';
            $message = 'Question has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('questionnaire.index')->with($status, $message);
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
