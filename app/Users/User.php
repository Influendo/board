<?php

namespace App\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * The user model
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'uid'];

    /**
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
