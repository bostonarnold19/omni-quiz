<?php

namespace App\Http\Controllers\Student;

use App\Answer;
use App\Http\Controllers\Controller;
use App\QuestionnaireCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Datatables;
use Modules\User\Entities\User;

class QuestionnaireController extends Controller {

    public function __construct() {
        $this->answer = new Answer;
        $this->middleware('permission:codes', ['only' => ['index']]);
        $this->middleware('permission:take-questionnaire', ['only' => ['create', 'store']]);
        $this->middleware('permission:codes', ['only' => ['show']]);

        $this->questionnaire_code = new QuestionnaireCode;
    }

    public function index(Request $request) {

        if ($request->ajax()) {
            $query = QuestionnaireCode::with(['user']);

            $dataTable = DataTables::of($query)
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereHas('user', function ($query) use ($keyword) {
                        $query->where('first_name', 'like', "%$keyword%")
                            ->orWhere('last_name', 'like', "%$keyword%");
                    });
                })
                ->addColumn('student_id', function ($data) {
                    $user = $data->user ?? User::find($data->user_id);
                    return @$user->student_id;
                })
                ->addColumn('name', function ($data) {
                    $user = $data->user ?? User::find($data->user_id);
                    return @$user->first_name . ' ' . @$user->last_name;
                })
                ->addColumn('action', function ($data) {
                    return '<a target="_blank" href="' . route('omni-questionnaire.show', $data->id) . '" class="btn btn-sm btn-secondary">Print Questionnaire</a>';
                })
                ->make(true);

            return $dataTable;
        }


        return view('modules.result.codes');
    }

    public function create(Request $request) {
        $auth = auth()->user();
        $data = $request->all();

        $question = null;
        // $answers = [];
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

                $questionnaire_code->time_start = Carbon::parse($time_now);
                $questionnaire_code->time_end = Carbon::parse($time_end);

                $questionnaire_code->update();

                // dd('first if');

            }






            if ($questionnaire_code->time_end > Carbon::now()) {
                $answers = $this->answer
                    ->where('user_id', $auth->id)
                    ->where('questionnaire_code_id', $questionnaire_code->id)
                    ->whereNull('question_option_id')
                    ->first();

                // $question = $questionnaire_code->questionnaire->questions->except($answers)->first();

                if ($answers) {
                    $question = $answers->question;
                }


                // dd('2nd if');

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


                $XXXXXXXXXXX = $this->questionnaire_code
                    ->where('codes', $data['codes'])
                    ->where('user_id', $auth->id)
                    ->first();

                // $questionnaire_code->time_start = Carbon::parse($questionnaire_code->time_start);
                // $questionnaire_code->time_end = Carbon::parse($questionnaire_code->time_end);


                return response()->json([
                    'questionnaire_code' => $XXXXXXXXXXX,
                    // 'answers' => $answers,
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
                    'passing' => $questionnaire_code->questionnaire->passing,
                    'items' => $questionnaire_code->questionnaire->questions->count(),
                    // 'answers' => $answers,
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
        // $answers = [];
        $question = null;

        $skip = 0;

        $skip = @$data['skip'];

        unset($data['time_start']);
        unset($data['time_end']);

        $auth = auth()->user();

        $put_ans = $this->answer->find($data['id']);
        $put_ans->update($data);

        // if (!isset($data['skip'])) {

        //     $data['answers'][] = $put_ans->question_id;

        //     $answers = $data['answers'];
        // }

        $questionnaire_code = $this->questionnaire_code->find($data['questionnaire_code']['id']);

        if ($questionnaire_code->time_end > Carbon::now()) {
            $question = null;

            $answers = $this->answer
                ->where('user_id', $auth->id)
                ->where('questionnaire_code_id', $questionnaire_code->id)
                ->whereNull('question_option_id');

            $c_q = $answers->count();

            if ($c_q === (int) $skip) {
                $skip = 0;

            }

            if ($answers->skip($skip)->first()) {
                $question = $answers->skip($skip)->first()->question;
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
                // 'answers' => $answers,
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
                'passing' => $questionnaire_code->questionnaire->passing,
                'items' => $questionnaire_code->questionnaire->questions->count(),
                // 'answers' => $answers,
            ], 200);
        }
    }

    public function show($id) {
        $questionnaire_code = $this->questionnaire_code->find($id);

        $answers = $this->answer
            ->where('questionnaire_code_id', $questionnaire_code->id)->get();

        return view('modules.result.print', compact('questionnaire_code', 'answers'));
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
