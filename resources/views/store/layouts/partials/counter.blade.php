<!--=====================================-->
<!--=       Counter Start               =-->
<!--=====================================-->
<section class="counter-wrap-layout1 bg-attachment-fixed" data-bg-image="/assets/images/figure/counter-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 d-flex justify-content-center">
                <div class="counter-box-layout1">
                    <div class="item-icon">
                        <i class="flaticon-gift"></i>
                    </div>
                    <div class="item-content">
                        <div class="counter-number">
                            <span class="counter">{{ App\Models\Listing::count() + 36200 }}</span>
                            <span>+</span>
                        </div>
                        <div class="item-title">اعلان</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center">
                <div class="counter-box-layout1">
                    <div class="item-icon">
                        <i class="flaticon-shield"></i>
                    </div>
                    <div class="item-content">
                        <div class="counter-number">
                            <span class="counter">{{ App\Models\User::whereNotNull('store_name')->count() + 1450 }}</span>
                            <span>+</span>
                        </div>
                        <div class="item-title">متجر موثق</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center">
                <div class="counter-box-layout1">
                    <div class="item-icon">
                        <i class="flaticon-users"></i>
                    </div>
                    <div class="item-content">
                        <div class="counter-number">
                            <span class="counter">{{ App\Models\User::count() + 63200 }}</span>
                            <span>+</span>
                        </div>
                        <div class="item-title">مستخدم</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>