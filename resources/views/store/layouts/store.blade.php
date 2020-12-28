<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ setting('website_name') }} | @yield('title')</title>
        @include('store.layouts.partials.head')
        @yield('head')
    </head>

    <body class="sticky-header">
        <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
        <!-- ScrollUp Start Here -->
        <a href="#wrapper" data-type="section-switch" class="scrollup">
            <i class="fas fa-angle-double-up"></i>
        </a>
        <!-- ScrollUp End Here -->
        <!-- Preloader Start Here -->
        <div id="preloader"></div>
        <!-- Preloader End Here -->
        <div id="wrapper" class="wrapper">

            @include('store.layouts.partials.header')

            @yield('content')
            
            @include('store.layouts.partials.footer')

            @auth
                @include('store.layouts.partials.chat-box')
            @endauth
            
            @yield('modals')
        </div>

        @include('store.layouts.partials.scripts')
        @yield('scripts')
    </body>
</html>