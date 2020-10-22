<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function sender() {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function recipient() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function listing() {
        return $this->belongsTo(Listing::class);
    }

    public function other_partey () {
        return auth()->user()->id == $this->sender->id ? $this->recipient : $this->sender;
    }
    
    public function messages() {
        return $this->hasMany(Message::class);
    }
}
