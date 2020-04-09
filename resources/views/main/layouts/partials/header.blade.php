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
                <div class="col-lg-2">
                    <div class="logo-area">
                        <a href="/" class="temp-logo float-right">
                            <img src="{{ setting('logo') }}" alt="logo" class="img-fluid" width="100">
                            <div style="font-size: 10px; color: #777; font-weight: bold; font-family: sans-serif;line-height: 25px;">إحدى شركات <span style="font-size: 11px;">حلول نعم</span></div>
                        </a>
                        <div class="float-right mr-3" style="line-height: 48px;">
                            <img src="https://www.countryflags.io/{{ country()->code }}/shiny/32.png"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-end" dir="ltr">
                    <nav id="dropdown" class="template-main-menu">
                        <ul dir="rtl">
                            <li><a href="/">الرئيسية</a></li>
                            <li><a href="/listings">الإعلانات</a></li>
                            <li><a href="/stores">المتاجر</a></li>
                            <li><a href="/about">من نحن</a></li>
                            <li><a href="/contact-us">اتصل بنا</a></li>

                            <li class="d-lg-none"><a href="/listings/add">نشر إعلان جديد</a></li>

                            @guest
                                <li class="d-lg-none"><a href="{{ route('login') }}">تسجيل الدخول</a></li>
                            @else
                                <li class="nav-item dropdown d-lg-none">
                                    <a id="navbarDropdown" class="nav-link color-primary w-100" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre title="بيانات الحساب">
                                         حسابي <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right w-100" aria-labelledby="navbarDropdown" dir="rtl">
                                        <a class="dropdown-item">{{ Auth::user()->name }}</a>
                                        @if(Auth::user()->is_admin() || Auth::user()->is_superadmin())
                                            <a class="dropdown-item" href="/admin">
                                                {{ __('Admin Panel') }}
                                            </a>
                                        @endif
                                        <a class="dropdown-item" href="/account">إعدادات الحساب</a>
                                        <a class="dropdown-item" href="/account#my-listing">إعلاناتي</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-4 d-flex justify-content-end">
                    <div class="header-action-layout1">
                        <ul>
                            @guest
                                <li class="header-login-icon">
                                    <a href="{{ route('login') }}" class="color-primary" data-toggle="tooltip" data-placement="top" title="تسجيل الدخول" style="font-size: 1.25rem">
                                        <i class="far fa-user"></i>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item header-login-icon mr-0">
                                    <a class="nav-link color-primary toggle-conversations" href="#" title="بيانات الحساب" style="font-size: 1.25rem">
                                        {{-- <span class="unread">2</span> --}}
                                        <i class="far fa-comment"></i>
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


<span class="d-lg-none mobile-nav-icon add-listing-btn"> 
    <a href="/listings/add" class="item-btn"><i class="fas fa-plus"></i> أضف إعلانك</a>
</span>
@auth
    <a class="d-lg-none mobile-nav-icon toggle-conversations">
        {{-- <span class="unread">2</span> --}}
        <i class="far fa-comment"></i>
    </a>

    @include('main.layouts.partials.conversations-dropdown')
@endauth

<div class="text-center text-white py-3 px-3" style="background: #f85c70;">
    <span>( دعاء دخول السوق )</span> <br>
    لا إله إلا الله وحده لا شريك له، له الملك وله الحمد يحيي ويميت وهو حي لا يموت، بيده الخير كله وهو على كل شيء قدير.
</div>