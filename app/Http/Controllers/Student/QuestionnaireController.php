<?php

namespace App\Http\Controllers\Student;

use App\Answer;
use App\Http\Controllers\Controller;
use App\QuestionnaireCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller {

    public function __construct() {
        $this->answer = new Answer;
        $this->questionnaire_code = new QuestionnaireCode;
    }

    public function index() {
        //
    }

    public function create(Request $request) {
        $auth = auth()->user();
        $data = $request->all();

        $question = null;
        $answers = [];
        if ($request->ajax()) {

            $questionnaire_code = $this->questionnaire_code
                ->where('codes', $data['codes'])
                ->where('user_id', $auth->id)
                ->first();

            $time_now = Carbon::now();

            if (isset($questionnaire_code) && empty($questionnaire_code->time_start)) {
                $questionnaire_code->time_start = $time_now;

                $time_q = explode(':', $questionnaire_code->questionnaire->time);

                $time_end = Carbon::now();
                $time_end->addMinutes($time_q[0]);
                $time_end->addSeconds($time_q[1] + 2);

                $questionnaire_code->time_start = $time_now;
                $questionnaire_code->time_end = $time_end;

                $questionnaire_code->update();
            }

            if ($questionnaire_code->time_end > Carbon::now()) {
                $answers = $this->answer
                    ->where('user_id', $auth->id)
                    ->where('questionnaire_code_id', $questionnaire_code->id)
                    ->whereNotNull('question_option_id')
                    ->pluck('question_id')
                    ->toArray();

                $question = $questionnaire_code->questionnaire->questions->except($answers)->first();
            }

            if (!empty($question)) {

                $answer = $this->answer
                    ->where('user_id', $auth->id)
                    ->where('question_id', $question->id)
                    ->where('questionnaire_code_id', $questionnaire_code->id)->first();

                if (empty($answer)) {

                    $data = [
                        'user_id' => $auth->id,
                        'question_id' => $question->id,
                        'questionnaire_code_id' => $questionnaire_code->id,
                    ];

                    $answer = $this->answer->create($data);
                }

                $questionnaire_code->time_start = Carbon::parse($questionnaire_code->time_start);
                $questionnaire_code->time_end = Carbon::parse($questionnaire_code->time_end);

                return response()->json([
                    'questionnaire_code' => $questionnaire_code,
                    'answers' => $answers,
                    'question' => $question,
                    'options' => $question->options,
                    'answer' => $answer,
                ], 200);

            } else {

                //SCORE
                $answers = $this->answer
                    ->where('user_id', $auth->id)
                    ->where('questionnaire_code_id', $questionnaire_code->id)->get();

                $score = 0;
                foreach ($answers as $key => $v_answer) {
                    if (isset($v_answer->answer) && $v_answer->answer->is_correct == 1) {
                        $score++;
                    }
                }

                $questionnaire_code->result = $score;
                $questionnaire_code->update();

                return response()->json([
                    'done' => true,
                    'score' => $score,
                    'items' => $questionnaire_code->questionnaire->questions->count(),
                    'answers' => $answers,
                ], 200);
            }

        } else {
            $questionnaire_code = $this->questionnaire_code
                ->where('codes', $data['codes'])
                ->where('user_id', $auth->id)
                ->first();
            if (isset($questionnaire_code) && !empty($questionnaire_code)) {
                return view('modules.questionnaire.create', compact('questionnaire_code'));
            } else {
                return redirect('dashboard')->withError('Invalid Code');
            }
        }
    }

    public function store(Request $request) {
        $data = $request->all();
        $answers = [];
        $question = null;

        $skip = 0;

        $skip = @$data['skip'];

        unset($data['time_start']);
        unset($data['time_end']);

        $auth = auth()->user();

        $put_ans = $this->answer->find($data['id']);
        $put_ans->update($data);

        if (!isset($data['skip'])) {

            $data['answers'][] = $put_ans->question_id;

            $answers = $data['answers'];
        }

        $questionnaire_code = $this->questionnaire_code->find($data['questionnaire_code']['id']);

        if ($questionnaire_code->time_end > Carbon::now()) {
            $question = null;
            $questions_execpts = $questionnaire_code->questionnaire->questions->except($answers);

            $c_q = $questions_execpts->count();

            if ($c_q === (int) $skip) {
                $skip = 0;

            }

            foreach ($questions_execpts as $k => $q) {
                if ($k < (int) $skip) {
                    continue;
                }
                $question = $q;
                break;
            }

        }

        if (!empty($question)) {

            $answer = $this->answer
                ->where('user_id', $auth->id)
                ->where('question_id', $question->id)
                ->where('questionnaire_code_id', $questionnaire_code->id)->first();

            if (empty($answer)) {

                $data = [
                    'user_id' => $auth->id,
                    'question_id' => $question->id,
                    'questionnaire_code_id' => $questionnaire_code->id,
                ];

                $answer = $this->answer->create($data);
            }

            $questionnaire_code->time_start = Carbon::parse($questionnaire_code->time_start);
            $questionnaire_code->time_end = Carbon::parse($questionnaire_code->time_end);

            return response()->json([
                'questionnaire_code' => $questionnaire_code,
                'answers' => $answers,
                'question' => $question,
                'options' => $question->options,
                'answer' => $answer,
                'skip' => @$skip,
            ], 200);

        } else {

            //SCORE
            $answers = $this->answer
                ->where('user_id', $auth->id)
                ->where('questionnaire_code_id', $questionnaire_code->id)->get();

            $score = 0;
            foreach ($answers as $key => $v_answer) {
                if (isset($v_answer->answer) && $v_answer->answer->is_correct == 1) {
                    $score++;
                }
            }

            $questionnaire_code->result = $score;
            $questionnaire_code->update();

            return response()->json([
                'done' => true,
                'score' => $score,
                'items' => $questionnaire_code->questionnaire->questions->count(),
                'answers' => $answers,
            ], 200);
        }
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
