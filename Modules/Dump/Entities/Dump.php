<?php

namespace Modules\Dump\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Dump extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = '';

    public $fillable = [
        //
    ];
}
