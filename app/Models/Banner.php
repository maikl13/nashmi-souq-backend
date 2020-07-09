<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FileHandler;
use Carbon\Carbon;

class Banner extends Model
{
    use FileHandler;

    protected $dates = ['created_at', 'updated_at', 'expires_at'];

    const TYPE_LARGE_RECTANGLE = 1;
    const TYPE_LEADERBOARD = 2;
    const TYPE_LARGE_LEADERBOARD = 3;
    const TYPE_MOBILE_BANNER = 4;

    public $images_path = "/assets/images/bs/";

    public static function valid()
    {
        return Self::query()->where('expires_at', '>', Carbon::now());
    }

    public function width()
    {
    	switch ($this->type) {
    		case Self::TYPE_LARGE_RECTANGLE: return 336; break;
    		case Self::TYPE_LEADERBOARD: return 728; break;
    		case Self::TYPE_LARGE_LEADERBOARD: return 970; break;
    		case Self::TYPE_MOBILE_BANNER: return 320; break;
    	}
    }

    public function height()
    {
        switch ($this->type) {
            case Self::TYPE_LARGE_RECTANGLE: return 280; break;
            case Self::TYPE_LEADERBOARD: return 90; break;
            case Self::TYPE_LARGE_LEADERBOARD: return 90; break;
            case Self::TYPE_MOBILE_BANNER: return 50; break;
        }
    }

    public function type()
    {
        switch ($this->type) {
            case Self::TYPE_LARGE_RECTANGLE: return 'Large Rectangle - 336x280'; break;
            case Self::TYPE_LEADERBOARD: return 'Leaderboard - 728x90'; break;
            case Self::TYPE_LARGE_LEADERBOARD: return 'Large Leaderboard - 970x90'; break;
            case Self::TYPE_MOBILE_BANNER: return 'Mobile Banner - 320x50'; break;
        }
    }

    public function expired()
    {
        return $this->expires_at->isPast();
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(Banner $banner) {
            // before delete() method call this
            $banner->delete_banner_image();
        });
    }
}