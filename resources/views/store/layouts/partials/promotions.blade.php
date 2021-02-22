<div class="bg-accent">
    <div class="" dir="ltr">
        <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="500" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="1" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="1" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="1" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="1" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="1" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
            @foreach (request()->store->promotions as $promotion)
                <a href="{{ $promotion->url }}"><img src="{{ $promotion->promotion_image() }}" class="w-100" alt="promotion image"></a>
            @endforeach
        </div>
    </div>
</div>

<section style="background-color: #eaeaea;">
    <div class="container">
        <div class="p-4">
            @include('store.layouts.partials.search-box')
        </div>
    </div>
</section>
