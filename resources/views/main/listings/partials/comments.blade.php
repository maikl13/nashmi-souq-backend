<div class="single-blog-box-layout1 pb-4" id="comments">
    <div class="blog-comment light-shadow-bg">
        <h3 class="widget-border-title">التعليقات 
            {{-- <small>{{ $listing->comments()->count() ? '('.$listing->comments()->parent()->count().')' : '' }}</small> --}}
        </h3>
        <div class="light-box-content comment-box">
            @auth
                <form action="/comments" method="post" class="ajax should-reset no-msg no-spinner comment-form" data-before-send="showLoading" data-on-complete="removeLoading" data-on-success="appendComment">
                    <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                    <textarea name="comment" rows="3" class="form-control mb-2" placeholder="اكتب تعليقك ..." required oninvalid="this.setCustomValidity('قم بكتابة تعليقك')" oninput="this.setCustomValidity('')"></textarea>
                    <button type="submit" class="btn btn-danger p-0 float-left" style="opacity: .75;">
                        <span style="border-left: 1px solid #e35f6c; padding: 9px 0;"><i class="fa fa-comment" style="padding: 11px;"></i></span>
                        <span class="px-3 d-inline-block">تعليق</span>
                    </button>
                </form>
            @else
                <div class="alert alert-danger py-4" style="opacity: .9;">
                    <i class="fa fa-lock ml-3" style="opacity: .8;"></i>
                    <span>قم <a href="{{ route('login') }}" class="text-danger" style="color: #6b1a22!important;">بتسجيل الدخول</a> لتتمكن من اضافة تعليق </span>
                </div>
            @endauth
            <div class="clearfix mb-5"></div>
            
            <div class="comments">
                @forelse ($comments = $listing->comments()->parent()->latest()->paginate(15) as $comment)
                    <div class="comment deletable" data-comment-id="{{ $comment->id }}">
                        @include('main.listings.partials.comment')

                        @foreach ($replies = $comment->replies()->simplePaginate(20, ['*'], 'replies'.$comment->id) as $comment)
                            @include('main.listings.partials.comment')
                        @endforeach
                        <div dir="ltr">{{ $replies->appends(request()->input())->links() }}</div>
                    </div>
                @empty
                    <div class="alert alert-default text-center" style="background-color: #f2f2f2; padding: 2rem 15px 3rem;">
                        <i class="fa fa-comments p-2" style="font-size: 2rem;"></i> <br>
                        <span style="font-size: 0.9rem;">قم بإضافة أول تعليق</span>
                    </div>
                @endforelse
                {{ $comments->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit-comment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">تعديل التعليق</div>
            <form class="edit-comment-form ajax should-reset no-msg" method="POST" action="/comments/edit" data-on-success="updateComment">
                <div class="modal-body">
                    <textarea class="form-control comment-body" name="comment" id="edit-comment-body" placeholder="قم بكتابة تعليقك هنا ..." rows="3" required autofocus></textarea>
                    <input class="comment-id" name="commentId" type="hidden" value="">
                </div>
                <div class="modal-footer text-center">
                    <input class="btn" href="#" data-dismiss="modal" value="إلغاء" style="width: 100px;">
                    <input type="submit" class="btn btn-danger" style="opacity: 0.8;" value="حفظ التغييرات">
                </div>
            </form>
        </div>
    </div>
</div>