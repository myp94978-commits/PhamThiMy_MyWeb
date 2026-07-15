<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'phone',
        'address',
        'gender',
        'birthday',
        'role',
        'status',
        'remember_token',
        'force_change_password',
    ];

    protected $hidden = [
        'password',
    ];
}
