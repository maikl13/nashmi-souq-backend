<?php

namespace App\Traits;

use Auth;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

trait ChatHandler {
    // get all user's conversations
    public function conversations(){
        $user_id = $this->id;
        return Conversation::where(function($query) use ($user_id){
            $query->where('recipient_id', $user_id)
                ->orWhere('sender_id', $user_id);
        });
    }

    // get one conversations between the aythenticated user and the user given as a parameter
    public function conversations_with(User $user){
        return Auth::user()->conversations()->where(function($query) use ($user){
            $query->where('recipient_id', $user->id)
                ->orWhere('sender_id', $user->id);
        });
    }

    public function messages(){
        return $this->hasMany('App\Models\Message', 'sender_id');
    }
}