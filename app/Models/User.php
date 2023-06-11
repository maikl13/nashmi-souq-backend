<?php

namespace App\Models;

use App\Traits\ChatHandler;
use App\Traits\ExchangeCurrency;
use App\Traits\FileHandler;
use App\Traits\ManageTransactions;
use App\Traits\SendOTP;
use App\Traits\StoreInfo;
use App\Traits\UserInfo;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, UserInfo, FileHandler, StoreInfo, ChatHandler, ManageTransactions, SendOTP, ExchangeCurrency;

    const ROLE_USER = 1;

    const ROLE_SUPERADMIN = 2;

    const ROLE_ADMIN = 3;

    protected $fillable = ['name', 'username', 'email', 'password', 'role_id', 'phone', 'phone_national', 'phone_country_code', 'otp'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'store_categories' => 'array',
    ];

    protected $appends = ['storebannerpath', 'storelogopath'];

    public static $profile_picture_sizes = [
        '' => ['w' => 256, 'h' => 256, 'quality' => 80],
        'o' => ['w' => null, 'h' => null, 'quality' => 100],
        'xxxs' => ['w' => 15, 'h' => 15, 'quality' => 70],
        'xxs' => ['w' => 32, 'h' => 32, 'quality' => 70],
        'xs' => ['w' => 64, 'h' => 64, 'quality' => 70],
        's' => ['w' => 128, 'h' => 128, 'quality' => 80],
        'l' => ['w' => 512, 'h' => 512, 'quality' => 90],
        'xl' => ['w' => 1000, 'h' => 1000, 'quality' => 100],
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

    public function orders()
    {
        return $this->HasMany(Order::class);
    }

    public function packages()
    {
        return $this->HasMany(Package::class);
    }

    public function store_packages()
    {
        return $this->HasMany(Package::class, 'store_id');
    }

    public function products()
    {
        return $this->HasMany(Product::class);
    }

    public function subscriptions()
    {
        return $this->HasMany(Subscription::class);
    }

    public function active_subscriptions()
    {
        return $this->HasMany(Subscription::class)->where('start', '<=', now())->where('end', '>=', now()->subDays(setting('grace_period')))->active();
    }

    public function url()
    {
        return '/users/'.$this->id;
    }

    public function profile_picture($options = [])
    {
        $options = array_merge($options, ['default' => 'user']);

        return $this->image($this->profile_picture, $options);
    }

    public function upload_profile_picture($file)
    {
        return $this->upload_file($file, 'profile_picture', ['ext' => 'jpg', 'sizes' => self::$profile_picture_sizes]);
    }

    public function store_banner($options = [])
    {
        $options = array_merge($options, ['default' => 'store-banner']);

        return $this->image($this->store_banner, $options) ?? null;
    }

    public function store_banner_get($options = [])
    {
        $options = array_merge($options, ['default' => 'store-banner']);

        return $this->image($this->store_banner, $options) ?? null;
    }

    public function upload_store_banner($file)
    {
        return $this->upload_file($file, 'store_banner', ['ext' => 'jpg', 'w' => 1180, 'h' => 300, 'allowed' => ['o', '', 's']]);
    }

    public function store_logo($options = [])
    {
        $options = array_merge($options, ['default' => 'store']);

        return $this->image($this->store_logo, $options) ?? null;
    }

    public function store_logo_get($options = [])
    {
        $options = array_merge($options, ['default' => 'store']);

        return $this->image($this->store_logo, $options) ?? null;
    }

    public function upload_store_logo($file)
    {
        return $this->upload_file($file, 'store_logo', ['ext' => 'jpg', 'w' => null, 'h' => null]);
    }

    public function getStoreBannerPathAttribute()
    {
        return $this->store_banner_get();
    }

    public function getStoreLogoPathAttribute()
    {
        return $this->store_logo_get();
    }

    public function has_reached_listings_limit()
    {
        $limit = setting('listings_limit');
        $timespan_in_hours = setting('listings_limit_timespan') ?: 24;

        if (! $limit || ! is_numeric($limit)) {
            return false;
        }

        return $this->listings()->whereBetween('created_at', [now()->subHours($timespan_in_hours), now()])->count() >= $limit;
    }

    public function remaining_time_to_be_able_to_post_listings()
    {
        $timespan_in_hours = setting('listings_limit_timespan') ?: 24;

        $latest_listing = auth()->user()->listings()->latest()->first();

        return now()->diffForHumans($latest_listing->created_at->addHours($timespan_in_hours), CarbonInterface::DIFF_ABSOLUTE, false, 2);
    }

    /**
     * Override the default function here
     * to allow using the website for those who registers by phone
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! $this->email || ! is_null($this->email_verified_at);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (User $user) {
            // before delete() method call this
            return $user->delete_file('profile_picture');
        });

        self::saving(function ($user) {
            if ($user->original['id'] ?? null) {
                if (($user->original['email'] ?? null) && $user->original['email'] != $user->email) {
                    $user->email_verified_at = null;
                    $user->sendEmailVerificationNotification();
                }
            }
        });
    }
}
