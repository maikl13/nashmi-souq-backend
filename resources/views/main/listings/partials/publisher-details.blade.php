<div class="widget-lg widget-author-info widget-light-bg">
    <h3 class="widget-border-title">معلومات الناشر</h3>
    <div class="author-content">
        <div class="author-name">
            <div class="item-img">
                <img src="{{ $listing->user->profile_picture(['size'=>'xxs']) }}" width="50" height="50" alt="author">
            </div>
            <h4 class="author-title"><a href="{{ $listing->user->url() }}">{{ $listing->user->name }}</a></h4>
        </div>
        <div class="author-meta">
            <ul>
                <li><i class="fas fa-shopping-basket"></i><a href="{{ $listing->user->url() }}">المزيد من الناشر</a></li>
            </ul>
        </div>

        {{-- @if($listing->user->phone)
            <div class="phone-number classima-phone-reveal not-revealed" data-phone="{{ Auth::check() ? $listing->user->phone : 'قم بتسجيل الدخول' }}">
                <div class="number"><i class="fas fa-phone"></i><span>{{ Str::limit($listing->user->phone, 4, 'XXXXXX') }}</span></div>
                <div class="item-text">إضغط هنا لإظهار رقم التلفون</div>
            </div>
        @endif

        @if(Auth::guest() || Auth::user()->id != $listing->user->id)
            <div class="author-mail">
                <a href="{{ Auth::check() ? '#' : route('login') }}" class="mail-btn {{ Auth::check() ? 'toggle-chat' : '' }}" data-name="{{ $listing->user->name }}" data-logo="{{ $listing->user->store_logo() }}" data-username="{{ $listing->user->username }}" data-listing="{{ $listing->id }}">
                    <i class="fas fa-envelope"></i> التحدث مع ناشر الإعلان
                </a>
            </div>
        @endif --}}
        
        <div class="row mt-4">
            @if (auth()->guest() || auth()->user()->id != $listing->user->id)
                <div class="col" style="padding: 0 !important;margin: 0 5px !important;white-space: nowrap;">
                    <a href="{{ Auth::check() ? '#' : route('login') }}" class="main-btn btn-block p-1 {{ Auth::check() ? 'toggle-chat' : '' }}" data-name="{{ $listing->user->store_name() }}" data-logo="{{ $listing->user->store_logo() }}" data-username="{{ $listing->user->username }}" data-listing="{{ $listing->id }}">
                        <i class="fa fa-envelope"></i> دردش
                    </a>
                </div>
            @endif
            <div class="col mb-1" style="padding: 0 !important;margin: 0 5px 5px 5px  !important;white-space: nowrap;">
                <a href="{{ Auth::check() ? 'tel:'.$listing->user->phone : route('login') }}" class="btn btn-info btn-block">
                    <i class="fa fa-phone"></i> إتصل
                </a>
            </div>
        </div>
    </div>
</div>  