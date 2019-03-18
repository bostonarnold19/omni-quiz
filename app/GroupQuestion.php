<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupQuestion extends Model
{
    public $fillable = [
        'title',
        'type',
        'description',
    ];

    public function questions()
    {
    	return $this->hasMany('App\Question');
    }
}
