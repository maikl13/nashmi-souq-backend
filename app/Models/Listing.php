<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FileHandler;
use App\Traits\SearchableTrait;
use Carbon\Carbon;
use DB;

class Listing extends Model
{
    use FileHandler, SearchableTrait;

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
            ->select('listings.*', 'featured_listings.listing_id', DB::raw("IF(`featured_listings`.`created_at` >= '".Carbon::now()->subDays( $this->period() )."', 1, Null) as `featured`"))
            ->orderByRaw('`featured` desc, rand()');
    }

    const TYPE_SELL = 1;
    const TYPE_BUY = 2;
    const TYPE_EXCHANGE = 3;
    const TYPE_JOB = 4;
    const TYPE_RENT = 5;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    
    public $images_path = "/assets/images/listing/";

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
        return $this->belongsTo(SubCategory::class);
    }

    public function country()
    {
        return $this->state->country();
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
            case Self::TYPE_JOB: return 'وظيفة'; break;
            case Self::TYPE_RENT: return 'إيجار'; break;
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
        return $this->featured_listings()->where('created_at', '>=', Carbon::now()->subDays( $this->period() ))->first() ? true : false;
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
        }
    }

    public function price()
    {
        return $this->price+0;
    }

    protected static $searchable = [
        'columns' => [
            'listings.title' => 3,
            'listings.slug' => 2,
            'listings.description' => 1,
        ],
    ];
}
