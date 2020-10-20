<div id="live-chat" class="closed" data-recipient="">
	<div class="chat" style="display: none;">
		<div class="p-3 chat-box-header text-white">
			<span class="recipient-name"></span>
			<i class="fa fa-times float-left"></i>
		</div>

		<div class="chat-box">
			<div class="chat-history">
				<div class="chat-message clearfix">
					<img src="" class="recipient-logo" alt="User Avatar">
					<div class="chat-message-content clearfix py-2">
						<span class="chat-time">{{ date('h:i') }}</span>
						<h5 class="mb-1 recipient-name" style="font-size: 14px; line-height: 1rem;"></h5>
						<p dir="auto" class="mb-1 recipient-slogan"></p>
					</div>
				</div>
			</div>

			<form action="/messages/add" method="post" class="chat-form" dir="ltr">
				@csrf
				<input type="hidden" name="recipient" class="recipient-username" value="">
				<textarea type="text" placeholder="رسالتك ..." id="chat-message" name="message" rows="1" class="pl-5 pr-3" autofocus dir="rtl" required oninvalid="this.setCustomValidity('قم بكتابة رسالتك')" oninput="this.setCustomValidity('')"></textarea>
				<button type="submit"><img src="/assets/images/send.svg" alt="Send"></button>
			</form>
		</div>
	</div>
</div> 