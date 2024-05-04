<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use App\QuestionOption;
use DB;
use Illuminate\Http\Request;
use Datatables;

class QuestionController extends Controller {

    public function __construct() {
        $this->question = new Question;
        $this->question_option = new QuestionOption;

        $this->middleware('permission:manage-question', ['only' => ['index', 'show']]);
        $this->middleware('permission:add-question', ['only' => ['store']]);
        $this->middleware('permission:edit-question', ['only`' => ['update']]);
        $this->middleware('permission:delete-question', ['only' => ['destroy']]);
    }

    public function index(Request $request) {
        if ($request->ajax()) {
            $questions = $this->question->whereNull('deleted');
            return Datatables::of($questions)
                ->addColumn('question', function ($question) {
                    return $question->question;
                })
                ->addColumn('subject', function ($question) {
                    return $question->subject;
                })
                ->addColumn('course', function ($question) {
                    return $question->course;
                })
                ->addColumn('action', function ($question) {
                    return view('modules.question.includes._index_action', compact('question'))->render();
                })
                ->rawColumns(['action'])
                ->toJson();
        } else {
            return view('modules.question.index');
        }
    }

    public function create() {
        return view('modules.question.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            // $data['time'] = $data['minute'].":".$data['second'];
            $question = $this->question->create($data);
            $correct = [];
            foreach (json_decode($data['is_correct']) as $n) {
                $correct[] = $n;
            }
            foreach ($data['description'] as $key => $value) {
                $insert_options = [
                    'description' => $value,
                    'question_id' => $question->id,
                    'is_correct' => null,
                ];
                if (in_array($key, $correct)) {
                    $insert_options['is_correct'] = "1";
                }
                $this->question_option->create($insert_options);
            }
            DB::commit();
            $status = 'success';
            $message = 'Question has been created.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('question.index')->with($status, $message);
    }

    public function show(Request $request, $id) {
        if (!$request->ajax()) {
            abort(404);
        }
        $question = $this->question->find($id);
        $data = [
            'id' => $question->id,
            'question' => $question->question,
            'subject' => $question->subject,
            'course' => $question->course,
            // 'time'=> $question->time,
            // 'minute'=> explode(":", $question->time)[0],
            // 'second'=> explode(":", $question->time)[1],
        ];
        foreach ($question->options as $key => $value) {
            if (!empty($value->is_correct)) {
                $data['is_correct'][] = $key;
            }
            $data['question_options'][] = $value->description;
        }
        return response()->json($data, 200);
    }

    public function edit($id) {
        $question = $this->questions->find($id);
        return view('modules.question.edit', compact('question'));
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $question = $this->question->find($data['id']);
            // $data['time'] = $data['minute'] . ":" . $data['second'];
            $question->fill($data);
            $question->save();
            foreach ($question->options as $v) {
                $v->delete();
            }
            $correct = [];
            foreach (json_decode($data['is_correct']) as $n) {
                $correct[] = $n;
            }
            foreach ($data['description'] as $key => $value) {
                $insert_options = [
                    'description' => $value,
                    'question_id' => $question->id,
                    'is_correct' => null,
                ];
                if (in_array($key, $correct)) {
                    $insert_options['is_correct'] = "1";
                }
                $this->question_option->create($insert_options);
            }
            DB::commit();
            $status = 'success';
            $message = 'Question has been updated.';
        } catch (\Exception $e) {
            dd($e);
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('question.index')->with($status, $message);
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $question = $this->question->find($id);
            $question->deleted = date('Y-m-d');
            $question->save();
            $status = 'success';
            $message = 'Question has been deleted.';
            DB::commit();
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('question.index')->with($status, $message);
    }
}
