<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FileHandler;
use App\Traits\SearchableTrait;

class Listing extends Model
{
    use FileHandler, SearchableTrait;

    // override newquery to get visitors country ads
    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->whereIn('state_id', country()->states()->pluck('id')->toArray());
    }

    const TYPE_SELL = 1;
    const TYPE_BUY = 2;
    const TYPE_EXCHANGE = 3;
    const TYPE_JOB = 4;
    const TYPE_RENT = 5;
    
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

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    public function area()
    {
        return $this->belongsTo(Area::class);
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

    protected static $searchable = [
        'columns' => [
            'listings.title' => 3,
            'listings.slug' => 2,
            'listings.description' => 1,
        ],
    ];
}
