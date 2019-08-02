<?php

namespace App\Http\Controllers\Student;

use App\Answer;
use App\Http\Controllers\Controller;
use App\QuestionnaireCode;
use Illuminate\Http\Request;

class ResultController extends Controller
{

    public function __construct()
    {
        $this->answer = new Answer;
        $this->questionnaire_code = new QuestionnaireCode;
        $this->middleware('permission:manage-result', ['only' => ['index']]);
    }

    private function result()
    {

    }

    public function index()
    {
        $auth = auth()->user();

        if ($auth->hasRole('admin')) {
            $qc = \DB::table('questionnaire_codes')
                ->join('users', 'users.id', '=', 'questionnaire_codes.user_id')
                ->join('questionnaires', 'questionnaires.id', '=', 'questionnaire_codes.questionnaire_id')
                ->select('questionnaire_codes.user_id', 'questionnaire_codes.questionnaire_id')
                ->groupBy('users.id', 'questionnaires.id')
                ->get();

        } else {
            $qc = \DB::table('questionnaire_codes')
                ->where('user_id', $auth->id)
                ->join('users', 'users.id', '=', 'questionnaire_codes.user_id')
                ->join('questionnaires', 'questionnaires.id', '=', 'questionnaire_codes.questionnaire_id')
                ->select('questionnaire_codes.user_id', 'questionnaire_codes.questionnaire_id')
                ->groupBy('users.id', 'questionnaires.id')
                ->get();
        }

        $questionnaire_codes = [];

        foreach ($qc as $key => $value) {

            $questionnaire_codes[$key] = $this->questionnaire_code
                ->where('user_id', $value->user_id)
                ->where('questionnaire_id', $value->questionnaire_id)
                ->get();
        }

        return view('modules.result.index', compact('questionnaire_codes'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $data = $request->all();

        dd($data);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
