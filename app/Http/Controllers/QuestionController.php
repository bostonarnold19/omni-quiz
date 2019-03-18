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
    public function __construct(
        User $user_model,
        GroupQuestion $group_question,
        Question $question,
        QuestionOption $question_option,
        UserQuestion $user_question
    ) {
        $this->user_model      = $user_model;
        $this->group_question  = $group_question;
        $this->question        = $question;
        $this->question_option = $question_option;
        $this->user_question   = $user_question;
    } 

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

}
