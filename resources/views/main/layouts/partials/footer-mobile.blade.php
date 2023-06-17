<!--=====================================-->
<!--=       Footer Start            =-->
<!--=====================================-->
<footer style="font-size: 0.95rem;margin-bottom: 70px;">
    <div class="bg-light py-3" style="filter: brightness(1.01)">
        <div class="container">
            <div class="footer-box-layout1 mb-0">
                <div class="text-center">
                    <a href="https://maroof.sa/businesses/details/152665" target="_blank" style="display: block; width: 150px; margin: 15px auto;">
                        <img src="{{ asset('assets/images/maroof.svg') }}" alt="Maroof Logo">
                    </a>
                </div>

                <ul class="footer-social text-center mt-2" style="filter: brightness(0.8);">
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

                <div class="text-center mx-auto mt-3" style="filter: hue-rotate(130deg);">
                    <a class="text-secondary mx-2" href="/about">من نحن</a>
                    <a class="text-secondary mx-2" href="/terms-and-conditions">شروط الإستخدام</a>
                    <a class="text-secondary mx-2" href="/safety-tips">قواعد السلامة</a>
                    <a class="text-secondary mx-2" href="/privacy-policy">سياسة الخصوصية</a>
                    <a class="text-secondary mx-2" href="/contact-us">إتصل بنا</a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light py-3" style="border-top: 1px solid whitesmoke;">
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