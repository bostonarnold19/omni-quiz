<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    public $fillable = [
        'question',
        'subject',
        'course',
    ];

    public function questionnaires() {
        return $this->belongsToMany('App\Questionnaire');
    }

    public function options() {
        return $this->hasMany('App\QuestionOption');
    }

}
