<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ setting('website_name') }} | @yield('title')</title>
        <meta name="description" content="@yield('description', setting('website_description'))">

        <!-- facebook open graph -->
        <meta property="og:site_name" content="{{ config('app.name') }}" />
        <meta property="og:locale" content="{{ app()->getLocale() }}" />
        <meta property="og:locale:alternate" content="{{ app()->getLocale() == 'en' ? 'ar' : 'en' }}" />
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="{{ setting('website_name') }} | @yield('title')">
        <meta property="og:description" content="@yield('description', setting('website_description'))">
        <meta property="og:image:height" content="256" />
        <meta property="og:image:width" content="256" />
        <!-- end facebook open graph -->

        <!-- twitter cards -->
        <meta name="twitter:card" content="summary"/>
        <meta name="twitter:site" content="@83XKU76et1Qoepo">
        <meta name="twitter:creator" content="@83XKU76et1Qoepo"/>
        <meta name="twitter:title" content="{{ setting('website_name') }} | @yield('title')"/>
        <meta name="twitter:description" content="@yield('description', setting('website_description'))">
        <!-- end twitter cards -->

        <meta property="og:image" content="@yield('image', asset('/assets/images/logosquare.jpg'))"/>
        <meta property="og:url" content="{{ request()->fullUrl() }}" />

        {{-- <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script> --}}
        @include('main.layouts.partials.head')
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

            @include('main.layouts.partials.header')

            @include('main.layouts.partials.search-box-wrapper')

            <div class="py-3 bg-light border-top" id="app-download" style="color: #555; display: none;">
                <div class="container">
                    <div class="d-flex justify-content-between mx-auto align-items-center" style="max-width: 700px;">
                        <p class="mb-0" style="font-size: .96rem;">تطبيق سوق نشمي للهواتف الذكية، تجربة أفضل و أكثر سهولة</p>
                        <a href="http://onelink.to/sznmf2" class="btn px-1 py-3 text-white bg-red mr-2 d-flex align-items-center justify-content-center" style="width: 190px; max-width: 500px; max-height: 45px; font-size: .95rem;">تحميل التطبيق</a>
                    </div>
                </div>
            </div>


            @yield('content')
            
            <div class="d-block d-lg-none">
                @include('main.layouts.partials.footer-mobile')
            </div>

            <div class="d-none d-lg-block">
                @include('main.layouts.partials.footer')
            </div>

            @auth
                @include('main.layouts.partials.chat-box')
            @endauth
            
            @yield('modals')
        </div>

        <div class="d-block d-lg-none">
            @include('main.layouts.partials.footer-nav')
        </div>

        @include('main.layouts.partials.search-modals')

        @include('main.layouts.partials.scripts')
        
        @include('main.layouts.partials.search-box-scripts')

        @yield('scripts')
    </body>
</html>