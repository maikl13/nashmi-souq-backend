<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UserInfo;
use App\Traits\FileHandler;

class User extends Authenticatable
{
    use Notifiable, UserInfo, FileHandler;

    const ROLE_USER = 1;
    const ROLE_SUPERADMIN = 2;
    const ROLE_ADMIN = 3;
    
    public $images_path = "/assets/images/user/";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(User $user) {
            // before delete() method call this
            $user->delete_profile_picture();
        });
    }
}
