<?php

namespace App\Http\Controllers\Admin;

use App\GroupQuestion;
use App\Http\Controllers\Controller;
use App\Question;
use DB;
use Illuminate\Http\Request;

class GroupQuestionController extends Controller {

    public function __construct() {
        $this->group_question = new GroupQuestion;
        $this->question = new Question;
    }

    public function index() {
        $group_questions = $this->group_question->all();
        return view('modules.group_question.index', compact('group_questions'));
    }

    public function create() {
        return view('modules.group_question.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $this->group_question->create($data);
            DB::commit();
            $status = 'success';
            $message = 'Group Question has been created.';
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
        $group_question = $this->group_questions->find($id);
        return view('modules.group_question.edit', compact('group_question'));
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $group_question = $this->group_question->update($id, $data);
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
}
