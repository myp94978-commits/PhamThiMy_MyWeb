<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
    ];

    protected $hidden = [
        'password',
    ];
}
