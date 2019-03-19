<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use App\QuestionOption;
use DB;
use Illuminate\Http\Request;

class QuestionController extends Controller {

    public function __construct() {
        $this->question        = new Question;
        $this->question_option = new QuestionOption;
    }

    public function index() {
        $questions = $this->question->all();
        return view('modules.question.index', compact('questions'));
    }

    public function create() {
        return view('modules.question.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            $question = $this->question->create($data);
            foreach ($data['description'] as $key => $value) {
                $insert_options = [
                    'description' => $value,
                    'question_id' => $question->id,
                    'is_correct' => null,
                ];
                if ($key == (int) $data['is_correct']) {
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
            'question'=> $question->question,
            'time'=> $question->time,
        ];
        foreach ($question->options as $key => $value) {
            if (!empty($value->is_correct)) {
                $data['is_correct'] = $key;
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
            $question->fill($data);
            $question->save();
            foreach ($question->options as $v) {
                $v->delete();
            }

            foreach ($data['description'] as $key => $value) {
                $insert_options = [
                    'description' => $value,
                    'question_id' => $question->id,
                    'is_correct' => null,
                ];
                if ($key == (int) $data['is_correct']) {
                    $insert_options['is_correct'] = "1";
                }
                $this->question_option->create($insert_options);
            }
            DB::commit();
            $status = 'success';
            $message = 'Question has been updated.';
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Internal Server Error. Try again later.';
            DB::rollBack();
        }
        return redirect()->route('question.index')->with($status, $message);
    }

    public function destroy($id) {
        try {
            DB::beginTransaction();
            $this->question->destroy($id);
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
