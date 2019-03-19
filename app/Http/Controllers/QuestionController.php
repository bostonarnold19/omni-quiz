<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use App\GroupQuestion;
use App\Question;
use App\QuestionOption;
use App\UserQuestion;

class QuestionController extends Controller
{
    public function __construct() {
        $this->user_model      = new User;
        $this->group_question  = new GroupQuestion;
        $this->question        = new Question;
        $this->question_option = new QuestionOption;
        $this->user_question   = new UserQuestion;
    } 
    // create functions start

    public function questionCreate(Request $request)
    {
        $data = $request->all();
        $this->group_question->create($data);
        return redirect()->back();
    }

    public function addQuestion(Request $request)
    {
        $data = $request->all();
        $this->question->create($data);
        return redirect()->back();
    }

    public function addQuestionOption(Request $request)
    {
        $data = $request->all();
        $this->question_option->create($data);
        return redirect()->back();
    }

    public function addUserQuestion(Request $request)
    {
        $data = $request->all();
        $this->user_question->create($data);
        return redirect()->back();
    }

    // create functions end

    // update functions start
    public function questionUpdate(Request $request, $id)
    {
        $data = $request->all();
        $group_question = $this->group_question->find($data['id']);
        if (empty($group_question)) {
            return redirect()->back();
        }
        $group_question->fill($data);
        $group_question->save();
        return redirect()->back();
    }

    public function updateQuestion(Request $request)
    {
        $data = $request->all();

        $question = $this->question->find($data['id']);
        if (empty($question)) {
            return redirect()->back();
        }
        $question->fill($data);
        $question->save();

        return redirect()->back();
    }

    public function updateQuestionOption(Request $request)
    {
        $data = $request->all();
        $question_o = $this->question_option->find($data['id']);
        if (empty($question)) {
            return redirect()->back();
        }
        $question_o->fill($data);
        $question_o->save();
        return redirect()->back();
    }

    // update functions end

    // delete question start

    public function questionDelete(Request $request, $id)
    {
        $data = $request->all();
        $group_question = $this->group_question->find($data['id']);
        if (empty($group_question)) {
            return redirect()->back();
        }
        $group_question->delete();
        return redirect()->back();
    }

    public function deleteQuestion(Request $request)
    {
        $data = $request->all();

        $question = $this->question->find($data['id']);
        if (empty($question)) {
            return redirect()->back();
        }
        $question->delete();

        return redirect()->back();
    }

    public function deleteQuestionOption(Request $request)
    {
        $data = $request->all();
        $question_o = $this->question_option->find($data['id']);
        if (empty($question)) {
            return redirect()->back();
        }
        $question_o->delete();
        return redirect()->back();
    }

    // delete question end


}
