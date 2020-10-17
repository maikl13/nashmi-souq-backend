<div class="comment deletable">
    <div class="media" id="comment-{{ $comment->id }}">
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
                            <a href="{{ $listing->url() }}/comments/{{ $comment->id }}/delete" class="delete pr-2 w-100 text-right py-1 no-msg">
                                <span style="font-size: 14px;"><i class="fa fa-trash ml-2"></i> حذف</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Replys --}}
    {{-- @for ($j = 1; $j <= rand(1,3); $j++)
        <div class="media reply deletable" id="comment-{{ $comment->id }}">
            <div class="item-logo">
                <img class="rounded-circle" width="50" height="50" src="/assets/images/user/default-user.png" alt="logo">
            </div>
            <div class="media-body">
                <h4 class="item-title m-0">RadiusTheme</h4>
                <div class="comment-date">1 year ago / July 11, 2018 @ 6:09 am</div>
                <p>RadiusTheme is a web development company for WordPress plugins, themes and subsystems. We reached to thousands of people who are using those products to enhance their WordPress.</p>
                <a href="#" class="reply-btn"><i class="fa fa-edit"></i> أضف رد</a>
            </div>
        </div>
    @endfor --}}
</div>