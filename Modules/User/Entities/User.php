<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Core\Traits\UuidForKey;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, UuidForKey;

    use SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    protected $table = 'users';

    public $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'profile_picture',
        'username',
        'email',
        'created_by',
        'email_verified_at',
        'password_crack',
        'password',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
