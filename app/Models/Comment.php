<?php

namespace App\Models;

use App\Notifications\CommentAdded;
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

    public function scopeParent($query)
    {
        return $query->whereNull('reply_on');
    }

    public function parent()
    {
        return self::where('id', $this->reply_on);
    }

    public function replies()
    {
        return self::where('reply_on', $this->id);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Comment $comment) {
            // before delete() method call this
            $comment->replies()->delete();
        });

        static::created(function (Comment $comment) {
            try {
                if ($comment->commentable_type == 'App\Models\Listing') {
                    $listing = $comment->commentable;
                    if ($comment->user_id != $listing->user_id) {
                        $listing->user->notify(new CommentAdded($comment));
                    }
                    if ($comment->reply_on) {
                        foreach ($comment->parent()->first()->replies()->groupBy('user_id')->get() as $reply) {
                            if ($reply->user_id != $comment->user_id && $reply->user_id != $comment->parent()->user_id) {
                                $reply->user->notify(new CommentAdded($comment));
                            }
                        }

                        if ($comment->parent()->first()->user_id != $comment->user_id) {
                            $comment->parent()->first()->user->notify(new CommentAdded($comment));
                        }
                    }
                }
            } catch (\Throwable $th) {
            }
        });
    }
}
