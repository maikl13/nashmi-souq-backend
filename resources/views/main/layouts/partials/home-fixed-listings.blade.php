@php
    $fixed_listings = App\Models\Listing::fixed()->localized()->active()->inRandomOrder()->limit(4)->get();
@endphp

@if(count($fixed_listings))
    <section class="section-padding-top-heading bg-white">
        <div class="container">
            <div class="heading-layout1">
                <h2 class="heading-title">الإعلانات المثبتة</h2>
            </div>
            <div class="">
                <div class="item-related-product">
                    <div class="light-box-content" dir="ltr">
                        <div class="rc-carousel" data-loop="true" data-items="4" data-margin="30" data-custom-nav="#owl-nav1" data-autoplay="true" data-autoplay-timeout="7000" data-smart-speed="1000" data-dots="false" data-nav="false" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="3" data-r-extra-large-nav="false" data-r-extra-large-dots="false">
            
                            @foreach($fixed_listings as $fixed_listing )
                                <div class="product-box-layout1 box-shadwo-light mb-1 mg-1 {{ $fixed_listing->is_featured() ? 'item-trending' : '' }} {{ $fixed_listing->is_fixed() ? 'item-fixed' : '' }}">
                                    <div>
                                        <a href="{{ $fixed_listing->url() }}" style="height: 250px;display: block;overflow: hidden;">
                                            <img src="{{ $fixed_listing->listing_image(['size'=>'xs']) }}" alt="Product" style="object-fit: cover;width: 100%;height: 100%;">
                                        </a>
                                    </div>
                                    <div class="item-content">
                                        <h3 class="item-title"><a href="{{ $fixed_listing->url() }}">{{ $fixed_listing->title }}</a></h3>
                                        <ul class="entry-meta" dir="rtl">
                                            <li><i class="far fa-clock"></i>{{ $fixed_listing->created_at->diffForHumans() }}</li>
                                            <li><i class="fas fa-map-marker-alt"></i>{{ $fixed_listing->state ? $fixed_listing->state->name : '' }}{{ $fixed_listing->area ? ', '.$fixed_listing->area->name : '' }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif