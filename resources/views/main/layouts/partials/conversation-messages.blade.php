@if(isset( $conversation ) && $conversation)
	@foreach( $conversation->messages as $message )
		@include('main.layouts.partials.chat-message')
	@endforeach
@endif