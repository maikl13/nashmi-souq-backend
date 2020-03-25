<!--=====================================-->
<!--=            Header Start           =-->
<!--=====================================-->
<header class="header">
    <div id="rt-sticky-placeholder"></div>
    <div id="header-menu" class="header-menu menu-layout2">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-2">
                    <div class="logo-area">
                        <a href="/" class="temp-logo">
                            <img src="/assets/images/logo-dark.png" alt="logo" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 d-flex justify-content-end" dir="ltr">
                    <nav id="dropdown" class="template-main-menu">
                        <ul>
                            <li><a href="/">الرئيسية</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="col-lg-3 d-flex justify-content-end">
                    <div class="header-action-layout1">
                        <ul>
                            @guest
                                <li class="header-login-icon">
                                    <a href="{{ route('login') }}" class="color-primary" data-toggle="tooltip" data-placement="top" title="تسجيل الدخول" style="font-size: 1.25rem">
                                        <i class="far fa-user"></i>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item dropdown header-login-icon">
                                    <a id="navbarDropdown" class="nav-link color-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre title="بيانات الحساب" style="font-size: 1.25rem">
                                         <i class="far fa-user"></i> <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" dir="rtl">
                                        @if(Auth::user()->is_admin() || Auth::user()->is_superadmin())
                                            <a class="dropdown-item" href="/admin">
                                                {{ __('Admin Panel') }}
                                            </a>
                                        @endif
                                        <a class="dropdown-item" href="/account">إعدادات الحساب</a>
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

                            <li class="header-btn">
                                <a href="post-ad.html" class="item-btn"><i class="fas fa-plus"></i>Post Your Ad</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>