<?php

namespace Modules\Dump\Entities;

use Illuminate\Database\Eloquent\Model;

class Dump extends Model implements Auditable {

    protected $table = '';

    public $fillable = [
        //
    ];
}
