<h6 class="px-3 py-3 text-center text-white mb-0" style="background: #f85c7bd4;">
	<i class="fa fa-comments ml-2"></i>
	<span>المحادثات</span>
</h6>

@forelse (Auth::user()->unique_conversations()->latest()->orderBy('updated_at', 'desc')->limit(25)->get() as $conversation)
	<a href="#" class="chat-message clearfix toggle-chat w-100 {{ $conversation->messages()->whereNull('seen')->first() ? 'unseen' : '' }}" data-name="{{ $conversation->other_partey()->name }}" data-logo="{{ $conversation->other_partey()->profile_picture() }}" data-username="{{ $conversation->other_partey()->username }}"
		style="border-bottom: 1px solid #f7f7f7;">
		<img src="{{ $conversation->other_partey()->profile_picture() }}" class="ml-2" style="width: 50px; height: 50px;">
		<div class="chat-message-content clearfix">
			@php
				$latest_message = $conversation->messages()->latest()->first();
			@endphp
			@if ($latest_message)
				<span class="chat-time">{{ $latest_message->created_at->format('d m Y') == date('d m Y') ? $latest_message->created_at->format('h:i') : $latest_message->created_at->format('d M') }}</span>
			@endif
			<h6 class="mb-0">{{ $conversation->other_partey()->name }}</h6>
			@if ($latest_message)
				<p class="mb-3">
					<small>{{ Str::limit($latest_message->message, 30, '...') }}</small>
				</p>
			@endif
		</div>
	</a>
@empty
	<div class="text-center py-5 px-2">
		<div class="py-5">
			<i class="fa fa-comments"></i> 
			<small style="font-size: 14px;">لم تقم ببدء أي محادثه حتى الآن</small>
		</div>
	</div>
@endforelse