<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireCode extends Model {
    public $fillable = [
        'user_id',
        'questionnaire_id',
        'codes',
        'retake',
        'is_official',
        'time_start',
        'time_end',
    ];

    public function questionnaire()
    {
        return $this->belongsTo('App\Questionnaire');
    }

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function getScoreAttribute()
    {
        return $this->answers()->whereHas('answer', function($query) {
            $query->where('is_correct', 1);
        })->count();
    }

    public function getItemsAttribute()
    {
        return $this->questionnaire->questions()->count();
    }
}
