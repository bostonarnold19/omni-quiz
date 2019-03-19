<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $fillable = [
        'question',
        'type',
        'time',
    ];

    public function group_question()
    {
    	return $this->belongsToMany('App\GroupQuestion');
    }

    public function options()
    {
    	return $this->hasMany('App\QuestionOption');
    }

}
