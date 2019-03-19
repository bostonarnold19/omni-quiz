<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupQuestion extends Model
{
    public $fillable = [
        'title',
        'type',
        'description',
        'is_published',
    ];

    public function questions()
    {
    	return $this->belongsToMany('App\Question');
    }
}
