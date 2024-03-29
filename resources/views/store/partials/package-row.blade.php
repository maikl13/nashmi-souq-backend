<?php
	$package = App\Models\Package::find($id);
	$order = $package ? $package->order : false;
?>

@if($package && $order)
	<div class="text-right mb-3 mx-1" dir="rtl">
		<div class="listing-box product-box-layout3 m-0 d-block" style="background: #f7f7f7;">
			<div class="package-header py-2" style="font-size: 19px;">
				<strong>طلب</strong> <small>#{{ $package->uid }}{{ '@'.$order->uid }}</small>
				<small class="float-left" style="opacity: .7">{{ $package->status() }}</small>
			</div>
			<div class="product-info">
				<div class="item-content">
					<ul class="entry-meta d-block">
						<li>
							<i class="far fa-user"></i>
							<a href="{{ config('app.url') }}/users/{{ $order->user->id }}/" title="{{ $order->buyer_name }}">{{ $order->user->name }}</a>
						</li>
						<li><i class="far fa-clock"></i> {{ $order->created_at->diffForHumans() }}</li>
						<li>
							<i class="fas fa-money-bill"></i>
							<span>وسيلة الدفع : </span>{{ $order->get_payment_method() }}
						</li>
						{{-- <li>
							<i class="fas fa-map-marker-alt"></i>
							<span>عنوان الشحن: </span>
							{{ $order->state->country->name }} - {{ $order->state->name }} ({{ $order->address }})
						</li> --}}
					</ul>
				</div>
			</div>
			@foreach ($package->package_items as $item)
				<?php $listing = $item->listing; ?>
				@if ($listing)
					<div class="w-100 d-block pt-4">
						<div class="item-img float-right">
							<a href="{{ $listing->url() }}" class="w-100">
								<img src="{{ $listing->listing_image(['size'=>'xxs']) }}" width="80" alt="Product">
							</a>
						</div>
						<div class="product-info">
							<div class="item-content">
								<h3 class="item-title mb-0">
									<a href="{{ $listing->url() }}">{{ $listing->title }}</a>
								</h3>
								<ul class="entry-meta d-block">
									<li><i class="fas fa-shopping-cart"></i> الكمية: {{$item->quantity }}</li>
								</ul>
							</div>
						</div>
					</div>
				@endif
			@endforeach
			<div class="btn-group header-btn mt-1">
				<a href="/dashboard/orders/{{ $package->id }}" class="item-btn mt-1 rounded-0 py-2">
					<i class="fa fa-link ml-2"></i> تفاصيل الطلب
					<small class="mr-2">{{ $package->uid }}</small>
				</a>
			</div>
		</div>
	</div>
@endif