<?php

namespace App\Http\Controllers\Student;

use App\Answer;
use App\Http\Controllers\Controller;
use App\QuestionnaireCode;
use Illuminate\Http\Request;

class ResultController extends Controller {

    public function __construct() {
        $this->answer = new Answer;
        $this->questionnaire_code = new QuestionnaireCode;
    }

    private function result() {

    }

    public function index() {
        $auth = auth()->user();
        $questionnaire_codes = $this->questionnaire_code->where('user_id', $auth->id)
            ->get()
            ->groupBy('questionnaire_id');

        return view('modules.result.index', compact('questionnaire_codes'));
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
