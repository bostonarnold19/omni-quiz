<?php

namespace App\Http\Controllers\Student;

use App\GroupQuestion;
use App\Http\Controllers\Controller;
use App\UserQuestion;
use Carbon\Carbon;
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
        $auth = auth()->user();
        $user_questions_taken = [];
        if ($request->ajax()) {
            $group_question = $this->group_question->find($request->questionnaire_id);
            $user_questions_taken = $this->user_question
                ->where('user_id', $auth->id)
                ->where('group_question_id', $request->questionnaire_id)
                ->orWhereNotNull('question_option_id')
                ->where('time_end', '<=', Carbon::now())
                ->pluck('question_id')
                ->toArray();

            $question = $group_question->questions->except($user_questions_taken)->first();

            if (!empty($question)) {

                //GET ITEM EXAM

                $user_question = $this->user_question
                    ->where('user_id', $auth->id)
                    ->where('question_id', $question->id)
                    ->where('group_question_id', $group_question->id)->first();

                if (empty($user_question)) {

                    $time_q = explode(':', $question->time);

                    $time_end = Carbon::now();
                    $time_end->addMinutes($time_q[0]);
                    $time_end->addSeconds($time_q[1]);

                    $data = [
                        'user_id' => $auth->id,
                        'question_id' => $question->id,
                        'group_question_id' => $group_question->id,
                        'time_start' => Carbon::now(),
                        'time_end' => $time_end,
                    ];

                    $user_question = $this->user_question->create($data);
                }

                return response()->json([
                    'user_questions_taken' => $user_questions_taken,
                    'question' => $question,
                    'options' => $question->options,
                    'user_question' => $user_question,
                ], 200);

            } else {

                //SCORE

                $user_questions = $this->user_question
                    ->where('user_id', $auth->id)
                    ->where('group_question_id', $request->questionnaire_id)
                    ->get();

                $score = 0;
                foreach ($user_questions as $key => $user_question) {
                    if (isset($user_question->answer) && $user_question->answer->is_correct == 1) {
                        $score++;
                    }
                }

                return response()->json([
                    'done' => true,
                    'score' => $score,
                    'items' => $group_question->questions->count(),
                    'user_questions' => $user_questions,
                ], 200);
            }

        } else {
            $group_question = $this->group_question->find($request->questionnaire_id);
            return view('modules.questionnaire.create', compact('group_question'));
        }
    }

    public function store(Request $request) {
        $data = $request->all();
        $user_questions_taken = [];

        unset($data['time_start']);
        unset($data['time_end']);

        $auth = auth()->user();

        $put_ans = $this->user_question->find($data['id']);
        $put_ans->update($data);

        $data['user_questions_taken'][] = $put_ans->question_id;

        $user_questions_taken = $data['user_questions_taken'];

        $group_question = $this->group_question->find($data['group_question_id']);

        $question = $group_question->questions->except($user_questions_taken)->first();

        if (!empty($question)) {

            //GET ITEM EXAM
            //Next question
            $user_question = $this->user_question
                ->where('user_id', $auth->id)
                ->where('question_id', $question->id)
                ->where('group_question_id', $group_question->id)->first();

            if (empty($user_question)) {

                $time_q = explode(':', $question->time);

                $time_end = Carbon::now();
                $time_end->addMinutes($time_q[0]);
                $time_end->addSeconds($time_q[1]);

                $data = [
                    'user_id' => $auth->id,
                    'question_id' => $question->id,
                    'group_question_id' => $group_question->id,
                    'time_start' => Carbon::now(),
                    'time_end' => $time_end,
                ];

                $user_question = $this->user_question->create($data);
            }
            return response()->json([
                'user_questions_taken' => $user_questions_taken,
                'question' => $question,
                'options' => $question->options,
                'user_question' => $user_question,
            ], 200);

        } else {

            //SCORE

            $user_questions = $this->user_question
                ->where('user_id', $auth->id)
                ->where('group_question_id', $data['group_question_id'])
                ->get();

            $score = 0;
            foreach ($user_questions as $key => $user_question) {
                if (isset($user_question->answer) && $user_question->answer->is_correct == 1) {
                    $score++;
                }
            }

            return response()->json([
                'done' => true,
                'score' => $score,
                'items' => $group_question->questions->count(),
                'user_questions' => $user_questions,
            ], 200);
        }

        return response()->json([
            'xx' => 'xx',
        ], 200);
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
