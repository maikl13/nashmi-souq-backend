<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;
    
    public function edit(User $user, Comment $comment)
    {
    	
        return $comment->user_id === $user->id;
    }
    
    public function delete(User $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }
}
