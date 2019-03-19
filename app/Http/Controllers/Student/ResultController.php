<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\UserQuestion;
use DB;
use Illuminate\Http\Request;

class ResultController extends Controller {

    public function __construct() {
        $this->user_questions = new UserQuestion;
    }

    public function index() {
        $user_questions = $this->user_questions
            ->select('group_question_id', DB::raw('count(*) as total'))
            ->groupBy('group_question_id')->get();
        return view('modules.result.index', compact('user_questions'));
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
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
