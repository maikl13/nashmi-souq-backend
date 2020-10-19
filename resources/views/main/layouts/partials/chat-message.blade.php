<div class="chat-message clearfix {{ $message->sender->id == Auth::user()->id ? '' : 'lefttoright' }}">
	<img src="{{ $message->sender->store_image(['size'=>'xxs']) }}" alt="" style="width: 40px; height: 40px; margin-top: 7px;">
	<div class="chat-message-content clearfix">
		<span class="chat-time">{{ $message->created_at->format('d m Y') == date('d m Y') ? $message->created_at->format('h:i') : $message->created_at->format('d M') }}</span>
		<h5 class="mb-0">{{ $message->sender->store_name() }}</h5>
		<p dir="auto" class="mb-3" style="word-break: break-all;">{!! nl2br($message->message) !!}</p>
	</div>
</div>