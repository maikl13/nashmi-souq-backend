<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ $store->store_name }} | @yield('title')</title>
        <meta name="description" content="@yield('description', $store->store_description)">
        
        <!-- facebook open graph -->
        <meta property="og:site_name" content="{{ config('app.name') }}" />
        <meta property="og:locale" content="{{ app()->getLocale() }}" />
        <meta property="og:locale:alternate" content="{{ app()->getLocale() == 'en' ? 'ar' : 'en' }}" />
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{ $store->store_name }} | @yield('title')">
        <meta property="og:description" content="@yield('description', setting('website_description'))">
        <meta property="og:image:height" content="256" />
        <meta property="og:image:width" content="256" />
        <!-- end facebook open graph -->

        <!-- twitter cards -->
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:site" content="@83XKU76et1Qoepo">
        <meta name="twitter:creator" content="@83XKU76et1Qoepo"/>
        <meta name="twitter:title" content="{{ $store->store_name }} | @yield('title')"/>
        <meta name="twitter:description" content="@yield('description', setting('website_description'))">
        <!-- end twitter cards -->

        <meta property="og:image" content="@yield('image', asset('/assets/images/logosquare.jpg'))"/>
        <meta property="og:url" content="{{ request()->fullUrl() }}" />

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