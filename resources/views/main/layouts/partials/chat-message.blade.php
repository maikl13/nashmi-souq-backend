<div class="chat-message clearfix">
	<img src="{{ method_exists($message->sender, 'profile_picture') && ( $message->sender->is_admin() || $message->sender->is_superadmin()) ? setting('logo') : '/assets/images/user/default-user.png' }}" alt="" style="width: 32px; height: 32px;">
	<div class="chat-message-content clearfix">
		<span class="chat-time">{{ $message->created_at->format('h:i') }}</span>
		<h5 class="mb-1">{{ method_exists($message->sender, 'profile_picture') && ( $message->sender->is_admin() || $message->sender->is_superadmin()) ? setting('name') : $message->sender->name }}</h5>
		<p dir="auto" class="mb-3" style="word-break: break-all;">{!! nl2br($message->message) !!}</p>
	</div> <!-- end chat-message-content -->
</div> <!-- end chat-message -->