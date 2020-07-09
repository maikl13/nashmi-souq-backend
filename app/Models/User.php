<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UserInfo;
use App\Traits\StoreInfo;
use App\Traits\FileHandler;
use App\Traits\ChatHandler;
use App\Traits\ManageTransactions;
use App\Traits\SendOTP;

class User extends Authenticatable
{
    use Notifiable, UserInfo, FileHandler, StoreInfo, ChatHandler, ManageTransactions, SendOTP;

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
        'name', 'username', 'email', 'password', 'role_id', 'phone', 'phone_national', 'phone_country_code', 'otp'
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


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function featured_listings()
    {
        return $this->hasManyThrough(FeaturedListing::class, Listing::class);
    }

    public function orders(){
        return $this->HasMany(Order::class);
    }

    public function store_orders(){
        return $this->HasMany(Order::class, 'store_id');
    }
    
    public function url()
    {
        return '/users/'.$this->id;
    }


    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(User $user) {
            // before delete() method call this
            $user->delete_profile_picture();
        });
    }
}
