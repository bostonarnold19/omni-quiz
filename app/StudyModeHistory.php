<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;

class StudyModeHistory extends Model
{
    public $fillable = [
        'user_id',
        'question_id',
        'subject',
        'subtopic',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
