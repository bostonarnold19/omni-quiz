<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserQuestion extends Model {
    public $fillable = [
        'user_id',
        'group_question_id',
        'question_id',
        'question_option_id',
        'time_start',
        'time_end',
    ];

    public function user() {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    public function group_question() {
        return $this->belongsTo('App\GroupQuestion');
    }

    public function question() {
        return $this->belongsTo('App\Question');
    }

    public function answer() {
        return $this->belongsTo('App\QuestionOption', 'question_option_id');
    }
}
