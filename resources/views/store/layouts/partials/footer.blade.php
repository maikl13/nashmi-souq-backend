<!--=====================================-->
<!--=       Footer Start            =-->
<!--=====================================-->
<footer>
    <div class="footer-top-wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center w-100">
                    <div class="footer-box-layout1">
                        <div class="footer-logo mb-3">
                            <img src="{{ request()->store->store_logo() }}" alt="logo" width="130" style="filter: contrast(0.4);"> <br>
                        </div>
                        <div class="clearfix"></div>
                        <p class="text-justify" style="text-align-last: center;">{{ request()->store->store_description }}</p>
                        <ul class="footer-social">
                            
                            @if(request()->store->store_social_accounts && is_array( json_decode(request()->store->store_social_accounts) ))
                                <div class="mt-3 text-center">
                                    @foreach (json_decode(request()->store->store_social_accounts) as $social_account)
                                        @foreach(['facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'pinterest'] as $brand)
                                            <?php $icon = 'fa fa-globe-africa'; ?>
                                            @if (strrpos($social_account, $brand.".com"))
                                                <?php $icon = 'fab fa-'.$brand; break; ?>
                                            @endif
                                        @endforeach
                                    <li><a href="{{ $social_account }}" target="_blank"><i class="{{ $icon }}"></i></a></li>
                                @endforeach
                                </div>
                            @endif
                            @if(request()->store->store_website)
                                <a href="{{ request()->store->store_website }}" class="text-white d-block"><i class="fas fa-globe-asia"></i> {{ request()->store->store_website }}</a>
                            @endif
                            @if (request()->store->store_email)
                                <a href="mail:{{ request()->store->store_email }}" class="text-white d-block"><i class="fas fa-envelope"></i> {{ request()->store->store_email }}</a>
                            @endif
                        </ul>
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
                        , تطوير <a href="https://brmjyat.com" target="_blank">برمجيات</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>