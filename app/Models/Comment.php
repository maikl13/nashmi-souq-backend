<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function commentable()
    {
        return $this->morphTo();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeParent($query){
        return $query->whereNull('reply_on');
    }
    
    public function replies()
    {
        return self::where('reply_on', $this->id);
    }
    
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(Comment $comment) {
            // before delete() method call this
            $comment->replies()->delete();
        });
    }
}
