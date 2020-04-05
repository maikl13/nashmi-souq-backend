@if(isset( $conversation ) && $conversation)
	@foreach( $conversation->messages as $message )
		@include('main.layouts.partials.chat-message')
	@endforeach
@else
	<div class="chat-message clearfix">
		<img src="{{ $recipient->store_logo() }}" alt="User Avatar">
		<div class="chat-message-content clearfix text-left py-2">
			<span class="chat-time">{{ date('h:i') }}</span>
			<h5 class="mb-1" style="font-size: 14px; line-height: 1rem;">{{ $recipient->store_name() }}</h5>
			<p dir="auto" class="mb-1">{{ $recipient->store_slogan }}</p>
		</div> <!-- end chat-message-content -->
	</div> <!-- end chat-message -->
@endif