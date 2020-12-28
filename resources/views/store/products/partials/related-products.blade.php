@if(App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->latest()->count())
    <div class="item-related-product light-shadow-bg">
        <div class="flex-heading-layout2">
            <h3 class="widget-border-title">منتجات ذات صلة</h3>
            <div id="owl-nav1" class="smart-nav-layout1" dir="ltr">
                <span class="rt-prev">
                    <i class="fas fa-angle-left"></i>
                </span>
                <span class="rt-next">
                    <i class="fas fa-angle-right"></i>
                </span>
            </div>
        </div>
        <div class="light-box-content" dir="ltr">
            <div class="rc-carousel" data-loop="true" data-items="4" data-margin="30" data-custom-nav="#owl-nav1" data-autoplay="false" data-autoplay-timeout="3000" data-smart-speed="1000" data-dots="false" data-nav="false" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="2" data-r-medium-nav="false" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="false" data-r-large-dots="false" data-r-extra-large="3" data-r-extra-large-nav="false" data-r-extra-large-dots="false">

                @foreach( App\Models\Product::where('category_id', $product->category_id)->where('products.id', '!=', $product->id)->latest()->limit(8)->get() as $related )
                    <div class="product-box-layout1 box-shadwo-light mb-1 mg-1">
                        <div class="item-img">
                            <a href="{{ $related->url() }}"><img src="{{ $related->product_image(['size'=>'xs']) }}" alt="Product"></a>
                        </div>
                        <div class="item-content">
                            <h3 class="item-title"><a href="{{ $related->url() }}">{{ $related->title }}</a></h3>
                            <ul class="entry-meta" dir="rtl">
                                <li><i class="far fa-clock"></i>{{ $related->created_at->diffForHumans() }}</li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endif