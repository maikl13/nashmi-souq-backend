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
use App\Traits\SendWhatsappMessage;
use App\Traits\SendOTP;
use App\Traits\ExchangeCurrency;

class User extends Authenticatable
{
    use Notifiable, UserInfo, FileHandler, StoreInfo, ChatHandler, ManageTransactions, SendWhatsappMessage, SendOTP, ExchangeCurrency;

    const ROLE_USER = 1;
    const ROLE_SUPERADMIN = 2;
    const ROLE_ADMIN = 3;
    
    protected $fillable = ['name', 'username', 'email', 'password', 'role_id', 'phone', 'phone_national', 'phone_country_code', 'otp'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];
    
    protected static $profile_picture_sizes = [
        '' => ['w'=>256, 'h'=>256, 'quality'=>80],
        'o' => ['w'=>null, 'h'=>null, 'quality'=>100],
        'xxxs' => ['w'=>15, 'h'=>15, 'quality'=>70],
        'xxs' => ['w'=>32, 'h'=>32, 'quality'=>70],
        'xs' => ['w'=>64, 'h'=>64, 'quality'=>70],
        's' => ['w'=>128, 'h'=>128, 'quality'=>80],
        'l' => ['w'=>512, 'h'=>512, 'quality'=>90],
        'xl' => ['w'=>1000, 'h'=>1000, 'quality'=>100],
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

    public function packages(){
        return $this->HasMany(Package::class);
    }

    public function store_packages(){
        return $this->HasMany(Package::class, 'store_id');
    }
    
    public function url()
    {
        return '/users/'.$this->id;
    }

    public function profile_picture( $options=[] ){
        $options = array_merge($options, ['default'=>'user']);
        return $this->image($this->profile_picture, $options);
    }
    public function upload_profile_picture($file){
        return $this->upload_file($file, 'profile_picture', ['ext'=>'jpg','sizes'=>Self::$profile_picture_sizes]);
    }

    public function store_banner( $options=[] ){
        $options = array_merge($options, ['default'=>'user']);
        return $this->image($this->store_banner, $options);
    }
    public function upload_store_banner($file){
        return $this->upload_file($file, 'store_banner', ['ext'=>'jpg','w'=>1180, 'h'=>300, 'allowed'=>['o', '', 's']]);
    }

    public function store_logo( $options=[] ){
        $options = array_merge($options, ['default'=>'user']);
        return $this->image($this->store_logo, $options);
    }
    public function upload_store_logo($file){
        return $this->upload_file($file, 'store_logo', ['ext'=>'jpg','sizes'=>Self::$profile_picture_sizes]);
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(User $user) {
            // before delete() method call this
            return $user->delete_file('profile_picture');
        });
    }
}
