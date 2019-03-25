<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model {
    public $fillable = [
        'title',
        'description',
        'subject',
        'course',
        'time',
        'is_published',
    ];

    public function questions() {
        return $this->belongsToMany('App\Question');
    }
}
