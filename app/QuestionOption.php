<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    public $fillable = [
        'description',
        'is_correct',
        'question_id',
    ];

    public function question()
    {
    	return $this->belongsTo('App\Question');
    }
}
