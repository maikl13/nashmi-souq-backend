<?php
	$order = App\Models\Order::find($id);
	$listing = $order ? $order->listing : false;;
?>

{{-- <div class="text-right" dir="rtl">
	<a href="{{ $order->listing->url() }}" class="float-right ml-2">{{ $order->title }}</a> <br>
	<!-- <small class="" style="opacity: .7">({{ $order->uid }})</small> -->
	<!-- <small class="float-left" style="opacity: .7">({{ $order->status() }})</small><br> -->

	<div>
		<span class="badge badge-info p-2 rounded-0" style="opacity: .7">الكمية: {{ $order->quantity }}</span>
	</div>
</div> --}}

@if($listing)
	<div class="text-right mb-3 mx-1">
	    <div class="listing-box product-box-layout3 m-0 d-block d-sm-flex">
	        <div class="item-img">
	            <a href="{{ $listing->url() }}">
	                <img src="{{ $listing->listing_image() }}" alt="Product">
	            </a>
	        </div>
	        <div class="product-info">
	            <div class="item-content">
	                <h3 class="item-title">
	                	<a href="{{ $listing->url() }}">{{ $listing->title }}</a>
	                	<small class="float-left" style="opacity: .7">{{ $order->status() }}</small>
	                </h3>
	                <ul class="entry-meta d-block">
	                    <li>
	                    	<i class="far fa-user"></i>
							<a href="/users/{{ $order->user->id }}/" title="{{ $order->buyer_name }}">{{ $order->user->name }}</a>
	                    </li>
	                    <li><i class="fas fa-shopping-cart"></i> الكمية: {{$order->quantity }}</li>
	                    <li><i class="far fa-clock"></i> {{ $order->created_at->diffForHumans() }}</li>
	                </ul>
	                <ul class="item-condition">
	                    <li>
	                    	<strong>عنوان الشحن: </strong>{{ $order->state->country->name }} - {{ $order->state->name }} ({{ $order->address }})
	                    </li>
	                    <li>
		                    <strong>وسيلة الدفع : </strong>{{ $order->payment_method() }}
	                    </li>
	                    {{-- <li>
		                    <strong>الشحن : </strong>{{$order->shipping_method() }}
	                    </li> --}}
	                </ul>
	                <div class="btn-group header-btn mt-1">
						<a href="/orders/{{ $order->id }}" class="item-btn mt-1 rounded-0 py-2">
							<i class="fa fa-link ml-2"></i> تفاصيل الطلب
							<small class="mr-2">{{ $order->uid }}</small>
						</a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endif