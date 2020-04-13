<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListingPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Listing $listing)
    {
    	if(!$listing->is_active()) return false;
        return $listing->user_id === $user->id;
    }


    public function delete(User $user, Listing $listing)
    {
        return $listing->user_id === $user->id;
    }
}
