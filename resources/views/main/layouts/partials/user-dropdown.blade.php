<li class="nav-item dropdown header-login-icon mr-0">
    <a id="navbarDropdown" class="nav-link color-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre title="بيانات الحساب" style="font-size: 1.25rem">
         <i class="far fa-user"></i>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" dir="rtl">
        <a class="dropdown-item">{{ Auth::user()->name }}</a>
        @if(Auth::user()->is_admin() || Auth::user()->is_superadmin())
            <a class="dropdown-item" href="/admin">
                {{ __('Admin Panel') }}
            </a>
        @endif
        <a class="dropdown-item" href="{{ Auth::user()->url() }}">صفحتي الشخصية</a>
        <a class="dropdown-item" href="/account">إعدادات الحساب</a>
        <a class="dropdown-item" href="/account/my-listing">إعلاناتي</a>
        @if (auth()->check() && auth()->user()->is_store())
            <a class="dropdown-item" href="{{ route('store-dashboard', auth()->user()->store_slug) }}">إدارة المتجر</a>
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