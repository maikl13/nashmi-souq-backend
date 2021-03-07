<!--=====================================-->
<!--=       Footer Start            =-->
<!--=====================================-->
<footer>
    <div class="footer-top-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="footer-box-layout1">
                        <div class="footer-logo mb-2">
                            <div class="float-right">
                                <img src="{{ setting('footer_logo') }}" alt="logo" width="130"> <br>
                                <span style="line-height: 37px;font-size: 13px;;color: #bbb; font-family: sans-serif;">احدي شركات <span style="font-size: 14px;">حلول نعم</span></span>
                            </div>
                            <div class="float-right mr-2" style="line-height: 70px;">
                                {{-- <img src="https://www.countryflags.io/{{ country()->code }}/shiny/48.png"/> --}}
                                <img src="https://flagcdn.com/w40/{{ country()->code }}.png" width="48"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <p>{{ setting('website_description') }}</p>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-8 col-xs-12">
                    <div class="footer-box-layout1">
                        <div class="footer-title mt-4 pb-3">
                            <h4 class="text-white mb-0">مواقع صديقة</h4>
                        </div>
                        <div class="footer-menu-box">
                            <ul>
                                @foreach (App\Models\Country::get() as $country)
                                    <li class="w-auto d-inline-block country-box">
                                        <a href="/c/{{ $country->code }}" class="px-2 py-1 m-1 d-inline-block" style="border: 1px solid #4a4a4a;">
                                            <img src="https://flagcdn.com/w40/{{ $country->code }}.png" width="24" style="opacity: .7;" />
                                            {{-- <img src="https://www.countryflags.io/{{ $country->code }}/shiny/24.png" style="opacity: .5;" /> --}}
                                            سوق {{ $country->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4 col-xs-12">
                    <div class="footer-box-layout1">
                        <div class="footer-title mt-4 pb-3">
                            <h4 class="text-white mb-0">قم بمتابعتنا</h4>
                        </div>
                        <ul class="footer-social">
                            @if( setting('facebook') )
                                <li><a href="{{ setting('facebook') }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if( setting('twitter') )
                                <li><a href="{{ setting('twitter') }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            @endif
                            @if( setting('instagram') )
                                <li><a href="{{ setting('instagram') }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            @endif
                            @if( setting('linkedin') )
                                <li><a href="{{ setting('linkedin') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                            @endif
                            @if( setting('youtube') )
                                <li><a href="{{ setting('youtube') }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            @endif
                            @if( setting('whatsapp') )
                                <li><a href="https://wa.me/{{ str_replace('+', '', setting('whatsapp') ) }}" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                            @endif
                        </ul>
                        
                        <div class="footer-title mt-4 pb-3">
                            <h4 class="text-white mb-0">قم بتحميل التطبيق</h4>
                        </div>
                        <div class="row footer-box-layout1">
                            <div class="text-center ml-2">
                                <a href="https://play.google.com/store/apps/details?id=nashmi.souq.store" target="_blank"> 
                                    <img style="border-radius: 20px;border: 3px solid #ffffff26;" width="130" src="/assets/images/googleplay.jpg">
                                </a>
                            </div>
                            <div class="text-center">
                                <a href="https://apple.co/3fNF3E9" target="_blank"> 
                                    <img style="border-radius: 20px;border: 3px solid #ffffff26;" width="130" src="/assets/images/appstore.jpg">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3 text-center d-none d-md-block">{!! ad('large_leaderboard') !!}</div>
                <div class="col mt-3 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
            </div>
            <div class="text-center mx-auto mt-4" style="filter: hue-rotate(130deg) brightness(1.5); margin-bottom: -20px;">
                <a class="text-secondary mx-2" href="/about">من نحن</a>
                <a class="text-secondary mx-2" href="/terms-and-conditions">شروط الإستخدام</a>
                <a class="text-secondary mx-2" href="/safety-tips">قواعد السلامة</a>
                <a class="text-secondary mx-2" href="/privacy-policy">سياسة الخصوصية</a>
                <a class="text-secondary mx-2" href="/contact-us">إتصل بنا</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright-text text-center">
                        جميع الحقوق محفوظة © 
                        <span style="text-transform: uppercase;">{{ setting('website_name') }} {{ date('Y') == '2020' ? '2020' : '2020 - '.date('Y') }}</span>
                        , تطوير <a href="https://brmjyat.com" target="_blank">برمجيات</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>