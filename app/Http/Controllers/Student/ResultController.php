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
        $this->middleware('permission:manage-result', ['only' => ['index']]);
    }

    private function result() {

    }

    public function index() {
        $auth = auth()->user();

        if ($auth->hasRole('admin')) {
            $questionnaire_codes = $this->questionnaire_code->all()
                ->groupBy('questionnaire_id');

        } else {
            $questionnaire_codes = $this->questionnaire_code->where('user_id', $auth->id)
                ->get()
                ->groupBy('questionnaire_id');
        }

        return view('modules.result.index', compact('questionnaire_codes'));
    }

    public function create() {
    }

    public function store(Request $request) {
        $data = $request->all();

        dd($data);
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
