<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    public $fillable = [
        'user_id',
        'questionnaire_code_id',
        'question_id',
        'question_option_id',
    ];

    public function user() {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    public function questionnaireCode() {
        return $this->belongsTo('App\QuestionnaireCode');
    }

    public function question() {
        return $this->belongsTo('App\Question');
    }

    public function answer() {
        return $this->belongsTo('App\QuestionOption', 'question_option_id');
    }
}
