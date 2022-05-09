@if (\App\Models\User::whereNotNull('store_name')->inRandomOrder()->count())
    <section class="section-padding-top-heading bg-accent">
        <div class="container">
            <div class="heading-layout1">
                <h2 class="heading-title">متاجر سوق نشمي</h2>
            </div>
            <div class="container" dir="ltr">
                <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="2" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="3" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="3" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="4" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="4" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="5" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                    @foreach(\App\Models\User::whereNotNull('store_name')->whereHas('products')->whereHas('active_subscriptions')->inRandomOrder()->limit(20)->get() as $store)
                        <div class="store-list-layout1">
                            <a href="{{ $store->store_url() }}">
                                <div class="item-logo">
                                    <img src="{{ $store->store_image(['size'=>'xs']) }}" style="width: 100%; height: 100px; object-fit: contain;" alt="store">
                                </div>
                                <div class="item-content" dir="rtl">
                                    <h3 class="item-title">{{ $store->store_name() }}</h3>
                                    <div class="ad-count">{{ $store->products()->count() }} منتج</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif