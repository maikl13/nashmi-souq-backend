<!--=====================================-->
<!--=       Footer Start            =-->
<!--=====================================-->
<footer>
    <div class="footer-top-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-sm-6">
                    <div class="footer-box-layout1">
                        <div class="footer-logo">
                            <img src="{{ setting('footer_logo') }}" alt="logo" width="130">
                        </div>
                        <p>{{ setting('website_description') }}</p>
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
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-box-layout1">
                        <div class="footer-title">
                            <h3>معلومات</h3>
                        </div>
                        <div class="footer-menu-box">
                            <ul>
                                <li><a href="/about">من نحن</a></li>
                                <li><a href="/terms-and-conditions">شروط الإستخدام</a></li>
                                <li><a href="/safety-tips">قواعد السلامة</a></li>
                                <li><a href="/privacy-policy">سياسة الخصوصية</a></li>
                                <li><a href="/contact">إتصل بنا</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
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
                        , تطوير <a href="https://brmjyat.com">برمجيات</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>