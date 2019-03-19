<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use DB;
use Illuminate\Http\Request;

class QuestionController extends Controller {

    public function __construct() {
        $this->question = new Question;
    }

    public function index() {
        $questions = $this->question->all();
        return view('modules.question.index', compact('questions'));
    }

    public function create() {
        return view('modules.question.create');
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
        return redirect()->route('group-question.index')->with($status, $message);
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $question = $this->questions->find($id);
        return view('modules.question.edit', compact('question'));
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $question = $this->question->update($id, $data);
            DB::commit();
            $status = 'success';
            $message = 'Question has been updated.';
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
            $this->question->delete($id);
            $status = 'success';
            $message = 'Question has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('group-question.index')->with($status, $message);
    }
}
