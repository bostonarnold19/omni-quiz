<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $fillable = [
        'question',
        'type',
        'group_question_id',
    ];

    public function group_question()
    {
    	return $this->belongsTo('App\GroupQuestion');
    }
}
