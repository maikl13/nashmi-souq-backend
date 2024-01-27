<?php

namespace App\Models;

use App\Traits\ExchangeCurrency;
use App\Traits\FileHandler;
use App\Traits\SearchableTrait;
use DB;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use ExchangeCurrency, FileHandler, SearchableTrait;

    protected $casts = ['options' => 'array'];
    
    protected $with = ['featured_listings'];

    protected $appends = ['imagespath'];

    public function scopeLocalized($query)
    {
        return $query->whereIn('state_id', country()->states()->pluck('id')->toArray());
    }

    public function scopeApiLocalized($query)
    {
        return $query->whereIn('state_id', country_api()->states()->pluck('id')->toArray());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeaturedOrFixed($query)
    {
        return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*', 'featured_listings.listing_id')
            ->whereRaw(DB::raw("IF('".now()."' < `featured_listings`.`expired_at`, 1, Null)"));
    }

    public function scopeFeaturedOrFixedFirst($query)
    {
        return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*',
                'featured_listings.listing_id',
                DB::raw("IF('".now()."' < `featured_listings`.`expired_at`, 1, Null) as `featured`"),
                DB::raw("IF('".now()."' < `featured_listings`.`expired_at` and `featured_listings`.`tier` >= 9, 2, 1) as `featuring_level`"),
            )
            ->orderByRaw('`featuring_level` desc, `featured` desc, `id` desc');
    }

    public function scopeFeatured($query)
    {
        return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*', 'featured_listings.listing_id')
            ->whereRaw(DB::raw("IF('".now()."' < `featured_listings`.`expired_at` and `featured_listings`.`tier` <= 8, 1, Null)"));
    }

    public function scopeFeaturedFirst($query)
    {
        return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*',
                'featured_listings.listing_id',
                DB::raw("IF('".now()."' < `featured_listings`.`expired_at` and `featured_listings`.`tier` <= 8, 1, Null) as `featuring_level`"),
            )
            ->orderByRaw('`featuring_level` desc, `id` desc');
    }

    public function scopeFixed($query)
    {
        return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*', 'featured_listings.listing_id')
            ->whereRaw(DB::raw("IF('".now()."' < `featured_listings`.`expired_at` and `featured_listings`.`tier` > 8, 1, Null)"));
    }

    public function scopeFixedFirst($query)
    {
        return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*',
                'featured_listings.listing_id',
                DB::raw("IF('".now()."' < `featured_listings`.`expired_at` and `featured_listings`.`tier` > 8, 1, Null) as `featuring_level`"),
            )
            ->orderByRaw('`featuring_level` desc, `id` desc');
    }

    const TYPE_SELL = 1;

    const TYPE_BUY = 2;

    const TYPE_EXCHANGE = 3;

    const TYPE_JOB = 4;

    const TYPE_RENT = 5;

    const TYPE_JOB_REQUEST = 6; // Added later after TYPE_JOB which represents job vacancy now

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 0;

    public function getRouteKeyName($value = '')
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function country()
    {
        return $this->state->country();
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function featured_listings()
    {
        return $this->hasMany(FeaturedListing::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->with('user');
    }

    public function url()
    {
        return '/listings/'.$this->slug;
    }

    public function type()
    {
        switch ($this->type) {
            case self::TYPE_SELL: return 'بيع';
                break;
            case self::TYPE_BUY: return 'شراء';
                break;
            case self::TYPE_EXCHANGE: return 'إستبدال';
                break;
            case self::TYPE_JOB: return 'عرض وظيفة';
                break;
            case self::TYPE_RENT: return 'إيجار';
                break;
            case self::TYPE_JOB_REQUEST: return 'طلب وظيفة';
                break;
        }
    }

    public function status()
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE: return 'فعال';
                break;
            case self::STATUS_INACTIVE: return 'غير فعال';
                break;
        }
    }

    public function is_active()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function is_featured()
    {
        if ($this->relationLoaded('featured_listings')) {
            return $this->featured_listings->whereIn('tier', [1, 2, 3, 4, 5, 6, 7, 8])->where('expired_at', '>', now())->first() ? true : false;
        }
        
        return $this->featured_listings()->whereIn('tier', [1, 2, 3, 4, 5, 6, 7, 8])->whereRaw(DB::raw("IF('".now()."' < `expired_at`, 1, Null)"))->first() ? true : false;
    }
    
    public function is_fixed()
    {
        if ($this->relationLoaded('featured_listings')) {
            return $this->featured_listings->whereIn('tier', [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])->where('expired_at', '>', now())->first() ? true : false;
        }

        return $this->featured_listings()->whereIn('tier', [9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])->whereRaw(DB::raw("IF('".now()."' < `expired_at`, 1, Null)"))->first() ? true : false;
    }

    public function price()
    {
        return $this->price + 0;
    }

    public function local_price()
    {
        // the price in local currency
        if (
            optional(country()->currency)->id == optional($this->currency)->id ||
            ! $this->currency
        ) {
            return $this->price();
        }

        return ceil(exchange($this->price, $this->currency->code, country()->currency->code));
    }

    public function is_available()
    {
        // for now i am gonna consider all listings"products" as available all the time
        return true;
    }

    public function is_eligible_for_cart(Type $var = null)
    {
        // To be able to add the listing to the cart
        // must be added by a store
        if (! $this->user->is_store()) {
            return false;
        }
        // store can't buy his own products
        if (auth()->user() && $this->user->id == auth()->user()->id) {
            return false;
        }
        // must be of type 'sell'
        if ($this->type != self::TYPE_SELL) {
            return false;
        }
        // the have a price
        if (! $this->price || $this->price <= 0) {
            return false;
        }
        // the price can't exceed 3000 usd to avoid adding cars and building
        if (exchange($this->price, $this->country->currency->code, 'USD') > 3000) {
            return false;
        }

        return true;
    }

    public static $listing_image_sizes = [
        'o' => ['w' => null, 'h' => null, 'quality' => 100],
        '' => ['w' => null, 'h' => null, 'quality' => 80],
        'xxs' => ['w' => 128, 'h' => null, 'quality' => 70],
        'xs' => ['w' => 256, 'h' => null, 'quality' => 70],
    ];

    public function listing_images($options = [])
    {
        $options = array_merge($options);

        return $this->images($this->images, $options);
    }

    public function listing_image($options = [])
    {
        $images = $this->listing_images($options);

        return array_shift($images);
    }

    public function upload_listing_images($files, $options = [])
    {
        $options = array_merge($options, ['ext' => 'jpg', 'sizes' => self::$listing_image_sizes, 'watermark' => true]);

        return $this->upload_files($files, 'images', $options);
    }

    public function getImagesPathAttribute()
    {
        $images = [];
        foreach ($this->listing_images() as $i) {
            $images[] = $i;
        }

        return $images;
    }

    protected static $searchable = [
        'columns' => [
            'listings.title' => 3,
            'listings.slug' => 2,
            'listings.description' => 1,
        ],
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($listing) {
            if (auth()->user()->has_reached_listings_limit()) {
                abort(403, __('عفوا لقد تخطيت الحد الأقصى لعدد الاعلانات المسموح بنشرها، برجاء الانتظار :remaining لتتمكن من نشر إعلان جديد', [
                    'remaining' => auth()->user()->remaining_time_to_be_able_to_post_listings(),
                ]));
            }
        });
    }
}
