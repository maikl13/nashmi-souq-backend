<?php $listing = App\Models\Listing::find($id); ?>

<a href="{{ $listing->url() }}" class="btn btn-sm btn-info" target="_blank"> <i class="fa fa-eye" ></i> </a>