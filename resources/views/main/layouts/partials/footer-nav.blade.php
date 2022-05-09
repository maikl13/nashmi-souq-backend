@php
    $path = str_replace(url('/'), '', url()->current());
@endphp
<div class="col shadow-lg footer-nav" style="bottom: 0; position: fixed; z-index: 100000; font-size: 0.85rem">
    <div class="row bg-white text-center">
        <div class="text-center" style="width: 18%;">
            <a href="{{ route('home') }}" class="d-block px-0 pt-3 pb-2 {{ $path == '' ? 'text-red' : ' text-secondary' }}">
                <i class="fa fa-home h6 mb-0 d-block"></i>
                <span>الرئيسية</span>
            </a>
        </div>
        <div class="text-center" style="width: 18%;">
            <a href="/stores" class="d-block px-0 pt-3 pb-2 {{ $path == '/stores' ? 'text-red' : 'text-secondary' }}">
                <i class="fa fa-shopping-cart h6 mb-0 d-block"></i>
                <span>المتاجر</span>
            </a>
        </div>
        <div class="text-center" style="width: 28%;">
            <a href="/listings/add" class="d-block px-0 pt-3 pb-2 text-white  {{ $path == '/listings/add' ? 'strong' : '' }}" 
                style="background: #F85C7C;">
                <i class="fa fa-plus h6 mb-0 d-block"></i>
                <strong>أضف إعلانك</strong>
            </a>
        </div>
        <div class="text-center" style="width: 18%;">
            <a href="{{ auth()->guest() ? route('login') : '#' }}" class="d-block px-0 pt-3 pb-2 text-secondary toggle-conversations">
                <span class="unread" style="display: none;">0</span>
                <i class="fa fa-envelope h6 mb-0 d-block"></i>
                <span>دردشة</span>
            </a>
        </div>
        <div class="text-center" style="width: 18%;">
            <a href="/account" class="d-block px-0 pt-3 pb-2 {{ ($path == '/account' || $path == '/login') ? 'text-red' : 'text-secondary' }}">
                <i class="fa fa-user h6 mb-0 d-block"></i>
                <span>حسابي</span>
            </a>
        </div>
    </div>
</div>
