<div class="widget-lg widget-author-info widget-light-bg">
    <h3 class="widget-border-title">معلومات الناشر</h3>
    <div class="author-content">
        <div class="author-name">
            <div class="item-img">
                <img src="{{ $product->user->store_image(['size'=>'xxs']) }}" width="50" height="50" alt="author">
            </div>
            <h4 class="author-title"><a href="{{ $product->user->url() }}">{{ $product->user->store_name() }}</a></h4>
        </div>
        <div class="author-meta">
            <ul>
                <li><i class="fas fa-shopping-basket"></i><a href="{{ $product->user->url() }}">المزيد من الناشر</a></li>
            </ul>
        </div>

        @if($product->user->phone)
            <div class="phone-number classima-phone-reveal not-revealed" data-phone="{{ Auth::check() ? $product->user->phone : 'قم بتسجيل الدخول' }}">
                <div class="number"><i class="fas fa-phone"></i><span>{{ Str::limit($product->user->phone, 4, 'XXXXXX') }}</span></div>
                <div class="item-text">إضغط هنا لإظهار رقم التلفون</div>
            </div>
        @endif

        @if(Auth::guest() || Auth::user()->id != $product->user->id)
            <div class="author-mail">
                <a href="{{ Auth::check() ? '#' : route('login') }}" class="mail-btn {{ Auth::check() ? 'toggle-chat' : '' }}" data-name="{{ $product->user->store_name() }}" data-logo="{{ $product->user->store_logo() }}" data-username="{{ $product->user->username }}" data-product="{{ $product->id }}">
                    <i class="fas fa-envelope"></i> التحدث مع ناشر المنتج
                </a>
            </div>
        @endif
    </div>
</div>  