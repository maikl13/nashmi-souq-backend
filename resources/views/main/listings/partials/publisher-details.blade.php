<div class="widget-lg widget-author-info widget-light-bg">
    <h3 class="widget-border-title">معلومات الناشر</h3>
    <div class="author-content">
        <div class="author-name">
            <div class="item-img">
                <img src="{{ $listing->user->store_image() }}" width="50" height="50" alt="author">
            </div>
            <h4 class="author-title"><a href="{{ $listing->user->url() }}">{{ $listing->user->store_name() }}</a></h4>
        </div>
        <div class="author-meta">
            <ul>
                <li><i class="fas fa-shopping-basket"></i><a href="{{ $listing->user->url() }}">المزيد من الناشر</a></li>
            </ul>
        </div>

        @if($listing->user->phone)
            <div class="phone-number classima-phone-reveal not-revealed" data-phone="{{ Auth::check() ? $listing->user->phone : 'قم بتسجيل الدخول' }}">
                <div class="number"><i class="fas fa-phone"></i><span>{{ Str::limit($listing->user->phone, 4, 'XXXXXX') }}</span></div>
                <div class="item-text">إضغط هنا لإظهار رقم التلفون</div>
            </div>
        @endif

        @if(Auth::guest() || Auth::user()->id != $listing->user->id)
            <div class="author-mail">
                <a href="{{ Auth::check() ? '#' : route('login') }}" class="mail-btn {{ Auth::check() ? 'toggle-chat' : '' }}" data-name="{{ $listing->user->store_name() }}" data-logo="{{ $listing->user->store_logo() }}" data-username="{{ $listing->user->username }}">
                    <i class="fas fa-envelope"></i> التحدث مع ناشر الإعلان
                </a>
            </div>
        @endif
    </div>
</div>  