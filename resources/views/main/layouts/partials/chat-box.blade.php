<div id="live-chat" class="closed">
	<header class="clearfix bg-primary float-right toggle-chat d-none">
		<i class="fa fa-comment" style="font-size: 24px;"></i>
		{{-- <span class="chat-message-counter bg-primary" style="display: inline;">3</span> --}}
	</header>
	<div class="clearfix"></div>

	<div class="chat" style="display: none;">
		<div class="p-3 toggle-chat text-white" style="line-height: 1rem; cursor: pointer; background: #f85c70; font-size: 14px;">
			<span>{{ $recipient->store_name() }}</span>
			<i class="fa fa-times float-left"></i>
		</div>

		<div class="chat-box">
			<div class="chat-history">
				@include('main.layouts.partials.conversation-messages')
			</div> <!-- end chat-history -->

			<form action="/messages/add" method="post" class="chat-form" dir="ltr">
				@csrf
				<div class="alert alert-danger error mb-0" style="display:none;"></div>
				<textarea type="text" placeholder="رسالتك ..." id="chat-message" name="message" rows="1" class="pl-5 pr-3" autofocus dir="rtl"></textarea>
				<button type="submit"><i class="fa fa-paper-plane"></i></button>
			</form>
		</div>

	</div> <!-- end chat -->

</div> <!-- end live-chat -->