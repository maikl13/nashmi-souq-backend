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
                            <img src="{{ request()->store->store_logo() }}" alt="logo" class="img-fluid" width="90">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-end" dir="ltr">
                    <nav id="dropdown" class="template-main-menu">
                        <ul dir="rtl">
                            <li><a href="/">الرئيسية</a></li>
                            <li><a href="/products">المنتجات</a></li>

                            @guest
                                <li class="d-lg-none"><a href="{{ route('login') }}">تسجيل الدخول</a></li>
                                <li class="d-lg-none"><a href="{{ route('register') }}">تسجيل حساب جديد</a></li>
                            @else
                                <li class="nav-item dropdown d-lg-none">
                                    <a id="navbarDropdown" class="nav-link color-primary w-100" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre title="بيانات الحساب">
                                         حسابي <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right w-100" aria-labelledby="navbarDropdown" dir="rtl">
                                        <a class="dropdown-item">{{ Auth::user()->name }}</a>
                                        <a class="dropdown-item" href="/my-orders">طلباتي</a>
                                        @if (auth()->check() && request()->store && request()->store->id == auth()->user()->id)
                                            <a class="dropdown-item" href="/orders">إدارة المتجر</a>
                                        @endif
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
                                        <span class="unread" {!! Auth::user()->recieved_messages()->unseen()->count() ? '' : 'style="display: none;"' !!}>{{ Auth::user()->recieved_messages()->unseen()->count() }}</span>
                                        <i class="far fa-envelope"></i>
                                    </a>
                                </li>

                                @include('store.layouts.partials.user-dropdown')
                            @endguest
                            
                            <li class="nav-item header-login-icon mr-0 cart-dropdown">
                                @include('store.partials.cart-dropdown')
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@guest
    <a class="d-lg-none mobile-nav-icon toggle-guestnav">
        <i class="far fa-user"></i>
    </a>
    <section style="display: none;" class="guestnav-dropdown">
        <div class="container" dir="ltr">
            <div class="row">
                <div class="col-12">
                    <a class="dropdown-item p-3" href="/login">تسجيل الدخول</a>
                    <a class="dropdown-item p-3" href="/register">حساب جديد</a>
                </div>
            </div>
        </div>
    </section>
@endguest
