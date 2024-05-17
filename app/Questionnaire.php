<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model {
    public $fillable = [
        'type',
        'title',
        'description',
        'subject',
        'course',
        'time',
        'passing',
        'deleted',
        'is_published',
        'is_official',
    ];

    public function questions() {
        return $this->belongsToMany('App\Question');
    }
}
