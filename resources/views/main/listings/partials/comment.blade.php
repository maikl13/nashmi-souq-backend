    <div class="media {{ $comment->reply_on ? 'reply deletable' : '' }}" id="comment-{{ $comment->id }}">
        <div class="item-logo">
            <img class="rounded-circle" width="70" height="70" src="{{ $comment->user->profile_picture() }}" alt="logo">
        </div>
        <div class="media-body">
            <h4 class="item-title m-0">{{ $comment->user->name }}</h4>
            <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
            <p class="mb-2 comment-text" style="white-space: break-spaces;">{{ $comment->body }}</p>
            <a href="#" class="reply-btn"><i class="fa fa-edit"></i> أضف رد</a>
            
            @if (Auth::user() && Auth::user()->id == $comment->user_id )
                <div class="more dropdown">
                    <a href="#" data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                    <ul class="dropdown-menu comment-more text-right" style="min-width: 100px;">
                        <li>
                            <a href="#" class="edit-comment w-100 pr-2 d-block py-1" data-comment-id="{{ $comment->id }}" data-toggle="modal" data-target="#edit-comment-modal">
                                <span style="font-size: 14px;"><i class="fa fa-edit ml-2"></i> تعديل</span>
                            </a>
                        </li>
                        <li>
                            <a href="/comments/{{ $comment->id }}/delete" class="delete pr-2 w-100 text-right py-1 no-msg">
                                <span style="font-size: 14px;"><i class="fa fa-trash ml-2"></i> حذف</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>