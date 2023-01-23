<?php

namespace App\Models;

use App\Traits\ExchangeCurrency;
use App\Traits\FileHandler;
use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use FileHandler, SearchableTrait, ExchangeCurrency, SoftDeletes;

    protected $casts = ['options' => 'array', 'shown' => 'boolean'];

    public function newQuery()
    {
        if (request()->store) {
            return parent::newQuery()->where('user_id', request()->store->id);
        }

        return parent::newQuery();
    }

    public function scopeShown($query)
    {
        return $query->where('shown', true);
    }

    public function getTitleAttribute()
    {
        $title = $this->getAttributes()['title'];
        foreach (optional($this->options)['values'] ?? [] as $option_value) {
            $option_value = \App\Models\OptionValue::find($option_value);
            if ($option_value) {
                $title .= ' - '.$option_value->name;
            }
        }

        return $title;
    }

    public function getOptionsAttribute()
    {
        $options = $this->getAttributes()['options'];
        if ($options && $options != '[]') {
            return json_decode($options, true);
        }

        return ['options' => [], 'values' => []];
    }

    public function getRouteKeyName($value = '')
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

    public function url()
    {
        return $this->user->store_url().'/products/'.$this->slug;
    }

    public function initial_price()
    {
        return $this->initial_price + 0;
    }

    public function price()
    {
        return $this->price + 0;
    }

    public function local_initial_price()
    {
        // the price in local currency
        if (
            optional(country()->currency)->id == optional($this->currency)->id ||
            ! $this->currency
        ) {
            return $this->initial_price();
        }

        return ceil(exchange($this->initial_price, $this->currency->code, country()->currency->code));
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
        // for now i am gonna consider all products"products" as available all the time
        return true;
    }

    public function is_eligible_for_cart(Type $var = null)
    {
        // // To be able to add the product to the cart
        // // must be added by a store
        // if(!$this->user->is_store()) return false;
        // // store can't buy his own products
        // if(auth()->user() && $this->user->id == auth()->user()->id) return false;
        // // must be of type 'sell'
        // if($this->type != Self::TYPE_SELL) return false;
        // // the have a price
        // if(!$this->price || $this->price <= 0) return false;
        // // the price can't exceed 3000 usd to avoid adding cars and building
        // if(exchange($this->price, $this->country->currency->code, 'USD') > 3000) return false;

        return true;
    }

    public static $product_image_sizes = [
        'o' => ['w' => null, 'h' => null, 'quality' => 100],
        '' => ['w' => null, 'h' => null, 'quality' => 80],
        'xxs' => ['w' => 128, 'h' => null, 'quality' => 70],
        'xs' => ['w' => 256, 'h' => null, 'quality' => 70],
    ];

    public function product_images($options = [])
    {
        $options = array_merge($options);

        return $this->images($this->images, $options);
    }

    public function product_image($options = [])
    {
        $images = $this->product_images($options);

        return array_shift($images);
    }

    public function upload_product_images($files, $options = [])
    {
        $options = array_merge($options, ['ext' => 'jpg', 'sizes' => self::$product_image_sizes, 'watermark' => true]);

        return $this->upload_files($files, 'images', $options);
    }

    protected static $searchable = [
        'columns' => [
            'products.title' => 3,
            'products.slug' => 2,
            'products.description' => 1,
        ],
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Product $product) {
            if ($product->shown) {
                $next_product_in_group = Product::whereGroup($product->group)->first();
                if ($next_product_in_group) {
                    $next_product_in_group->shown = true;
                    $next_product_in_group->save();
                }
            }
        });
    }
}
