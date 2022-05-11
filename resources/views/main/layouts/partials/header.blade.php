<!--=====================================-->
<!--=            Header Start           =-->
<!--=====================================-->
<style>
    .mean-container .mean-nav ul li a {font-weight: normal;}
</style>
 
<header class="header">
    <div id="rt-sticky-placeholder"></div>
    <div id="header-menu" class="header-menu menu-layout2">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-3 col-xl-2">
                    <div class="logo-area">
                        <a href="/" class="temp-logo float-right">
                            <img src="{{ setting('logo') }}" alt="logo" class="img-fluid" width="90">
                            <div style="font-size: 9px; color: #777; font-weight: bold; font-family: sans-serif;line-height: 25px;">إحدى شركات <span style="font-size: 10px;">حلول نعم</span></div>
                        </a>
                        <a class="float-right toggle-countries mr-1" style="line-height: 48px;">
                            <img src="https://flagcdn.com/w40/{{ country()->code }}.png" width="32"/>
                            <i class='fa fa-caret-down mr-2 h5'></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-6 d-flex justify-content-end" dir="ltr">
                    <nav id="dropdown" class="template-main-menu">
                        <ul dir="rtl">
                            {{-- <li><a href="/">الرئيسية</a></li> --}}
                            <li><a href="/listings">الإعلانات</a></li>
                            {{-- <li><a href="/stores">المتاجر</a></li> --}}
                            <li><a href="/about">من نحن</a></li>
                            <li class="d-lg-none"><a href="/terms-and-conditions">شروط الإستخدام</a></li>
                            <li class="d-lg-none"><a href="/safety-tips">قواعد السلامة</a></li>
                            <li class="d-lg-none"><a href="/privacy-policy">سياسة الخصوصية</a></li>
                            <li><a href="/contact-us">اتصل بنا</a></li>

                            {{-- <li class="d-lg-none"><a href="/listings/add">نشر إعلان جديد</a></li> --}}

                            @guest
                                <li class="d-lg-none"><a href="{{ route('login') }}">تسجيل الدخول</a></li>
                                <li class="d-lg-none"><a href="{{ route('register') }}">تسجيل حساب جديد</a></li>
                            @else
                                <li class="d-lg-none">
                                    <a>حسابي</a>

                                    <ul>
                                        <li>
                                            <a href="/users/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
                                        </li>
                                        <li>
                                            @if(Auth::user()->is_admin() || Auth::user()->is_superadmin())
                                                <a class="dropdown-item py-2" href="/admin">
                                                    {{ __('Admin Panel') }}
                                                </a>
                                            @endif
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="/account">إعدادات الحساب</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="/account/my-listing">إعلاناتي</a>
                                        </li>
                                        <li>
                                            @if (auth()->check() && auth()->user()->is_store())
                                                <a class="dropdown-item py-2" href="{{ route('store-dashboard', auth()->user()->store_slug) }}">إدارة المتجر</a>
                                            @endif
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest

                            <li class="d-lg-none flex-grow-1"></li>

                            <li class="d-lg-none text-center py-4 header-social border-0" style="background-color: #fdfdfd;">
                                <h3 class="text-muted">تواصل معنا</h3>
                                
                                <div class="d-flex flex-wrap justify-content-center" style="gap: 10px;">
                                    @if( setting('facebook') )
                                        <a href="{{ setting('facebook') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                    @endif
                                    @if( setting('twitter') )
                                        <a href="{{ setting('twitter') }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                    @endif
                                    @if( setting('instagram') )
                                        <a href="{{ setting('instagram') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                    @endif
                                    @if( setting('linkedin') )
                                        <a href="{{ setting('linkedin') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                    @endif
                                    @if( setting('youtube') )
                                        <a href="{{ setting('youtube') }}" target="_blank"><i class="fab fa-youtube"></i></a>
                                    @endif
                                    @if( setting('whatsapp') )
                                        <a href="https://wa.me/{{ str_replace('+', '', setting('whatsapp') ) }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                    @endif
                                </div>
                            </li>
                            <li class="d-lg-none py-3 border-0">
                                <div class="text-center" style="font-size: .85rem;">
                                    جميع الحقوق محفوظة © 
                                    <span style="text-transform: uppercase;">{{ setting('website_name') }} {{ date('Y') }}</span>
                                    , تطوير <a class="d-inline w-auto float-none p-0 m-0" href="https://brmjyat.com" target="_blank">برمجيات</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-4 d-flex justify-content-end p-0">
                    <div class="header-action-layout1">
                        <ul>
                            @guest
                                <li class="header-login-icon">
                                    <a href="{{ route('login') }}" class="color-primary" style="font-size: 1.12rem">
                                        <i class="fa fa-sign-in-alt" style="vertical-align: middle;"></i> 
                                        <small class="pr-1">تسجيل الدخول</small>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item header-login-icon mr-0">
                                    <a class="nav-link color-primary toggle-conversations" href="#" title="بيانات الحساب" style="font-size: 1.25rem">
                                        <span class="unread" {!! Auth::user()->recieved_messages()->unseen()->count() ? '' : 'style="display: none;"' !!}>{{ Auth::user()->recieved_messages()->unseen()->count() }}</span>
                                        <i class="far fa-envelope"></i>
                                    </a>
                                </li>

                                @include('main.layouts.partials.user-dropdown')
                            @endguest

                            <li class="header-btn">
                                <a href="/listings/add" class="item-btn">
                                    <i class="fas fa-plus"></i> أضف إعلانك
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@include('main.layouts.partials.header-nav-mobile')

@auth
    @include('main.layouts.partials.conversations-dropdown')
@endauth
    
@include('main.layouts.partials.countries-modal')

@if (setting('notification'))
    <div class="text-center text-white py-3 px-3 d-none d-lg-block" style="background: #f85c70;">
        <div class="container">{!! nl2br(e(setting('notification'))) !!}</div>
    </div>
@endif

@if (setting('notification2'))
    <div class="text-center py-3 px-3" style="background: #efeef1; color: #555;">
        <div class="container">{!! nl2br(e(setting('notification2'))) !!}</div>
    </div>
@endif
