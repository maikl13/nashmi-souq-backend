<div class="single-blog-box-layout1">
    <div class="blog-comment light-shadow-bg">
        <h3 class="widget-border-title">التعليقات <small>{{ $listing->comments()->count() ? '('.$listing->comments()->count().')' : '' }}</small></h3>
        <div class="light-box-content comment-box">
            @auth
                <form action="{{ $listing->url() }}/comments" method="post" class="ajax should-reset no-msg" data-on-success="appendComment">
                    <textarea name="comment" rows="3" class="form-control mb-2" placeholder="اكتب تعليقك ..." required></textarea>
                    <button type="submit" class="btn btn-danger p-0 float-left" style="opacity: .75;">
                        <i class="fa fa-comment" style="border-left: 1px solid #e35f6c;padding: 11px;"></i>
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
                @forelse ($listing->comments()->latest()->get() as $comment)
                    @include('main.listings.partials.comment')
                @empty
                    <div class="alert alert-default text-center" style="background-color: #f2f2f2; padding: 2rem 15px 3rem;">
                        <i class="fa fa-comments p-2" style="font-size: 2rem;"></i> <br>
                        <span style="font-size: 0.9rem;">قم بإضافة أول تعليق</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>