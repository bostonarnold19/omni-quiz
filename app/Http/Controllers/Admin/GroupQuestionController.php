<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use App\QuestionnaireCode;
use App\Questionnaire;
use App\Answer;
use App\QuestionOption;
use DB;
use Illuminate\Http\Request;

class GroupQuestionController extends Controller {

    public function __construct() {
        $this->group_question = new Questionnaire;
        $this->question = new Question;
        $this->answer = new Answer;
        $this->questionnaire_code = new QuestionnaireCode;
        $this->question_option = new QuestionOption;

        $this->middleware('permission:manage-group-question', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-group-question', ['only' => ['store']]);
        $this->middleware('permission:edit-group-question', ['only`' => ['update']]);
        $this->middleware('permission:delete-group-question', ['only' => ['destroy']]);

    }

    public function index() {
        $questionaires = $this->group_question->where('is_official', 1)->whereNull('deleted')->get();
        $questions = $this->question->all();
        $subjects = $this->parseSubjects($questions);
        return view('modules.group_question.index', compact('questionaires', 'questions', 'subjects'));
    }

    public function create() {
        return view('modules.group_question.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        $data['time'] = $data['minute'] . ":" . $data['second'];
        $subjects = explode(" | ", $data['select_subject']);
        $data['subject'] = $subjects[0];
        $data['course'] = $subjects[1];
        $questions = $this->question->query()->where('subject', $subjects[0])
            ->where('course', $subjects[1])
            ->whereNull('deleted')
            ->take((int) $data['question_count'])
            ->orderByRaw(DB::raw('RAND()'))->get();

        try {
            DB::beginTransaction();
            if (isset($data['is_published'])) {
                $data['is_published'] = 1;
            } else {
                $data['is_published'] = null;
            }
            $group_q = $this->group_question->create($data);
            if ($questions) {
                foreach ($questions as $q) {
                    $group_q->questions()->attach($q);
                }
            }
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
        $data['time'] = $data['minute'] . ":" . $data['second'];
        try {
            DB::beginTransaction();
            $group_q = $this->group_question->find($data['id']);
            if (isset($data['is_published'])) {
                $data['is_published'] = 1;
            } else {
                $data['is_published'] = null;
            }

            $group_q->fill($data);
            $group_q->save();

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
            $group_q = $this->group_question->find($id);
            $group_q->deleted = date('Y-m-d');
            $group_q->save();
            // $group_q->questions()->detach();
            // $this->group_question->destroy($id);
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

    private function parseSubjects($questions) {
        if (empty($questions)) {
            return [];
        }
        $datas = [];
        foreach ($questions as $key => $value) {
            if (in_array($value->subject . " | " . $value->course, $datas)) {
                continue;
            }
            $datas[] = $value->subject . " | " . $value->course;
        }
        return $datas;
    }
}
