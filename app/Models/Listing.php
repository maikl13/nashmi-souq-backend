<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FileHandler;
use App\Traits\SearchableTrait;
use App\Traits\ExchangeCurrency;
use Carbon\Carbon;
use DB;

class Listing extends Model
{
    use FileHandler, SearchableTrait, ExchangeCurrency;

    public function scopeLocalized($query){
        return $query->whereIn('state_id', country()->states()->pluck('id')->toArray());
    }

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function scopeFeatured($query, $strict=false){
        if($strict){
            return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
                ->select('listings.*', 'featured_listings.listing_id')
                ->whereRaw(DB::raw("IF(`featured_listings`.`created_at` >= '".Carbon::now()->subDays( $this->period() )."', 1, Null)"));
        }

        return $query->leftJoin('featured_listings', 'listings.id', '=', 'featured_listings.listing_id')
            ->select('listings.*', 
                'featured_listings.listing_id', 
                DB::raw("IF(`featured_listings`.`created_at` >= '".Carbon::now()->subDays( $this->period() )."', 1, Null) as `featured`"),
                DB::raw("IF(`featured_listings`.`tier` >= 9, 2, 1) as `featuring_level`"),
            )
            ->orderByRaw('`featuring_level` desc, `featured` desc, `id` desc');
    }

    const TYPE_SELL = 1;
    const TYPE_BUY = 2;
    const TYPE_EXCHANGE = 3;
    const TYPE_JOB = 4;
    const TYPE_RENT = 5;
    const TYPE_JOB_REQUEST = 6; // Added later after TYPE_JOB which represents job vacancy now

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    

	public function getRouteKeyName($value='')
	{
		return 'slug';
	}

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->state->country->currency();
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
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function url()
    {
    	return '/listings/'. $this->slug;
    }

    public function type()
    {
        switch ($this->type) {
            case Self::TYPE_SELL: return 'بيع'; break;
            case Self::TYPE_BUY: return 'شراء'; break;
            case Self::TYPE_EXCHANGE: return 'إستبدال'; break;
            case Self::TYPE_JOB: return 'عرض وظيفة'; break;
            case Self::TYPE_RENT: return 'إيجار'; break;
            case Self::TYPE_JOB_REQUEST: return 'طلب وظيفة'; break;
        }
    }

    public function status()
    {
        switch ($this->status) {
            case Self::STATUS_ACTIVE: return 'فعال'; break;
            case Self::STATUS_INACTIVE: return 'غير فعال'; break;
        }
    }

    public function is_active()
    {
        return $this->status == Self::STATUS_ACTIVE;
    }

    public function is_featured()
    {
        return $this->featured_listings()->whereIn('tier', [1,2,3,4,5,6,7,8])->where('created_at', '>=', Carbon::now()->subDays( $this->period() ))->first() ? true : false;
    }

    public function is_fixed()
    {
        // the function name is wrong, i know but i culdn't find a better name :D
        return $this->featured_listings()->whereIn('tier', [9,10,11,12,13,14,15,16,17,18,19,20])->where('created_at', '>=', Carbon::now()->subDays( $this->period() ))->first() ? true : false;
    }

    public function period()
    {
        switch ($this->tier) {
            case 1: return 1; break;
            case 2: return 3; break;
            case 3: return 7; break;
            case 4: return 15; break;
            case 5: return 30; break;
            case 6: return 90; break;
            case 7: return 180; break;
            case 8: return 365; break;

            case 9: return 30; break;
            case 10: return 60; break;
            case 11: return 90; break;
            case 12: return 120; break;
            case 13: return 150; break;
            case 14: return 180; break;
            case 15: return 210; break;
            case 16: return 240; break;
            case 17: return 270; break;
            case 18: return 300; break;
            case 19: return 330; break;
            case 20: return 360; break;
        }
    }

    public function price()
    {
        return $this->price+0;
    }

    public function local_price()
    {
        // the price in local currency
        if(country()->id == $this->country->id) return $this->price();
        return ceil(exchange($this->price, $this->country->currency->code, country()->currency->code));
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
        if(!$this->user->is_store()) return false;
        // store can't buy his own products
        if(auth()->user() && $this->user->id == auth()->user()->id) return false;
        // must be of type 'sell'
        if($this->type != Self::TYPE_SELL) return false;
        // the have a price
        if(!$this->price || $this->price <= 0) return false;
        // the price can't exceed 3000 usd to avoid adding cars and building
        if(exchange($this->price, $this->country->currency->code, 'USD') > 3000) return false;

        return true;
    }

    public static $listing_image_sizes = [
        'o' => ['w'=>null, 'h'=>null, 'quality'=>100],
        '' => ['w'=>null, 'h'=>null, 'quality'=>80],
        'xxs' => ['w'=>128, 'h'=>null, 'quality'=>70],
        'xs' => ['w'=>256, 'h'=>null, 'quality'=>70],
    ];
    
    public function listing_images( $options=[] ){
        $options = array_merge($options);
        return $this->images($this->images, $options);
    }
    public function listing_image($options=[]){
        $images = $this->listing_images($options);
        return array_shift($images);
    }
    public function upload_listing_images($files, $options=[]){
        $options = array_merge($options, ['ext'=>'jpg','sizes'=>Self::$listing_image_sizes, 'watermark'=>true]);
        return $this->upload_files($files, 'images', $options);
    }

    protected static $searchable = [
        'columns' => [
            'listings.title' => 3,
            'listings.slug' => 2,
            'listings.description' => 1,
        ],
    ];
}
