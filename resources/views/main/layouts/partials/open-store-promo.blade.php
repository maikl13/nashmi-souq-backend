@if(setting('open_store_section') || setting('open_store_section_header'))
    <section class="counter-wrap-layout1 bg-attachment-fixed" data-bg-image="/assets/images/figure/counter-bg.jpg">
        <div class="container">
            <div class="row" dir="ltr">
                <div class="col-lg-10 offset-lg-1 d-flex justify-content-center">
                    <div class="counter-box-layout1" dir="rtl">
                        <div class="item-content text-center">
                            <div style="font-size: 70px; color: #f85c70; margin-bottom: 30px;"> <i class="far fa-check-circle"></i> </div>
                            <div class="mb-4" style="font-size: 24px; color: white; font-weight: bold;">{{ setting('open_store_section_header') }}</div>
                            <div class="item-title text-justify" style="font-weight: normal; font-size: 17px; line-height: 33px; text-align-last: center;">{!! nl2br( e(setting('open_store_section')) ) !!}</div>

                            <a href="/stores/pricing" style="color: white;background: #f85c70;font-weight: bold;padding: 15px 35px; border-radius: 30px; margin-top: 20px;display: inline-block;">قم بإنشاء متجرك الآن مجانا</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif