<section class="section-padding-top-heading bg-accent">
    <div class="container home-listings-wrapper">
        <div class="heading-layout1">
            <i class="fa fa-bookmark h5 text-red ml-2 mb-0"></i>
            <h2 class="heading-title h4 font-weight-normal d-inline">أحدث الإعلانات</h2>
        </div>

        <div class="row listings">
            @include('main.layouts.partials.home-listings')
        </div>

        <div class="row">
            <div class="col-sm-12 text-center">
                <div class="d-none d-lg-block">
                    <a class="more-listings btn btn-default btn-block mb-3 py-3 px-5" style="background: #e65c70;color: white;cursor: pointer;">
                        المزيد من الإعلانات
                    </a>
                </div>
                <div class="d-block d-lg-none">
                    <a class="more-listings h2 mt-1 d-block mb-5" style="color: #F85C7C;"></a>
                </div>
            </div>
        </div>

        {{-- ad spaces --}}
        <div class="d-none d-lg-block">
            <div class="container" dir="ltr">
                <div class="rc-carousel" data-loop="true" data-items="10" data-margin="30" data-autoplay="true" data-autoplay-timeout="2000" data-smart-speed="1000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
                    @foreach (ads('large_rectangle', 10) as $ad)
                        {!! $ad !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>