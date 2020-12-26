@if(isset( $conversations ) && $conversations)
	@foreach( $conversations as $conversation )

		@if ($c_listing = $conversation->listing()->first())
			<div class="pt-2"></div>
			<a class="chat-message clearfix d-block p-1 mt-1 rounded" href="{{ $c_listing->url() }}" target="_blank" style="box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); margin: 0 -10px;">
				<img src="{{ $c_listing->listing_image(['size'=>'xxs']) }}" class="ml-2" style="width: 58px; height: 58px; margin: -4px; border-radius: 0;">
				<div class="chat-message-content clearfix">
					<p dir="auto" class="mb-0" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 14px; direction: rtl; text-align: right; margin-top: 15px;">{!! $c_listing->title !!}</p>
				</div>
			</a>
		@endif

		@foreach( $conversation->messages as $message )
			@include('main.layouts.partials.chat-message')
		@endforeach

	@endforeach
@endif