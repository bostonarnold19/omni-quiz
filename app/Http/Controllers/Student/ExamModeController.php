<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Questionnaire;
use App\Answer;
use App\QuestionnaireCode;
use DB;

class ExamModeController extends Controller
{
    public function __construct()
    {
        $this->group_question = new Questionnaire;
        $this->question = new Question;
        $this->questionnaire_code = new QuestionnaireCode;
        $this->answer = new Answer;
    }

    public function index()
    {
        $user = auth()->user();

        $questionnaire_code = $this->questionnaire_code->where('user_id', $user->id)
            ->where('is_official', 0)
            ->where(function($query) {
                $query->where('time_start', '<=',date('Y-m-d H:i:s'))
                ->where('time_end', '>=',date('Y-m-d H:i:s'))
                ->orWhereNull('time_start')
                ->orWhereNull('time_end');
            })->whereNull('result')->first();
        if (!$questionnaire_code) {
            return redirect(url('/dashboard'));
        }

        $score = $questionnaire_code->score;
        $items = $questionnaire_code->items;
        return view('modules.exam_mode.index', compact('questionnaire_code', 'score', 'items'));
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (!$request->ajax()) {
            return $this->createMockExam($request);
        }
        $questionQuery = $this->question->with('options');

        if (@$data['question_ids']) {
            $questionQuery->whereNotIn('id', @$data['question_ids']);
        }

        $question = $questionQuery->inRandomOrder()->first();
        return response()->json(['question' => $question]);
    }

    public function show($id)
    {

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

    private function createMockExam(Request $request) {
        $data = $request->all();
        $data['time'] = "60:00" ;
        $data['subject'] = $data['select_subject'];
        $data['question_count'] = 30;
        $course = auth()->user()->course;

        $questions = $this->question->query()
            ->where('subject', $data['subject'])
            ->where('course', $course)
            ->whereNull('deleted')
            ->take((int) $data['question_count'])
            ->orderByRaw(DB::raw('RAND()'))->get();

        try {
            DB::beginTransaction();
            $data['is_published'] = 1;
            $group_q = $this->group_question->create($data);
            if ($questions) {
                foreach ($questions as $q) {
                    $group_q->questions()->attach($q);
                }
            }
            $questionnaire_code_data['user_id'] = auth()->id();
            $questionnaire_code_data['questionnaire_id'] = $group_q->id;
            $questionnaire_code_data['codes'] = strtotime(date('Y-m-d h:i:s'));
            $questionnaire_code = $this->questionnaire_code->create($questionnaire_code_data);
            $questions = $questionnaire_code->questionnaire->questions()->inRandomOrder()->get();

            foreach ($questions as $q) {
                $data = [
                    'user_id' => $questionnaire_code->user_id,
                    'question_id' => $q->id,
                    'questionnaire_code_id' => $questionnaire_code->id,
                ];
                $answer = $this->answer->create($data);
            }

            DB::commit();
            $status = 'success';
            $message = 'Group Question has been created.';
            return redirect()->route('exam-mode.index');
        } catch (\Exception $e) {
            dd($e);
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
            return redirect()->back()->with($status, $message);
        }
    }
}
