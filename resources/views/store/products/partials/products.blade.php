<div class="product-filter-heading">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="item-title">
                @if($products->total() == 0)
                    إظهار {{ $products->total() }} منتج
                @else
                    إظهار {{ $products->firstItem() }}-{{ $products->lastItem() }} من {{ $products->total() }} منتج
                @endif
            </h2>
        </div>
        <div class="col-md-6 d-flex justify-content-md-end justify-content-center">
            <div class="product-sorting">
                <div class="layout-switcher">
                    <ul>
                        <li>
                            <a href="#" data-type="product-box-list" class="product-view-trigger">
                                <i class="fas fa-th-list"></i>
                            </a>
                        </li>
                        <li class="active">
                            <a class="product-view-trigger" href="#" data-type="product-box-grid">
                                <i class="fas fa-th-large"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="product-view" class="product-box-grid">
    <div class="row">
        @forelse($products as $product)
            <div class="col-xl-4 col-md-6">
                <div class="product-grid-view">
                    <div class="grid-view-layout2">
                        <div class="product-box-layout1">
                            <div class="item-img">
                                <a href="{{ $product->url() }}"><img src="{{ $product->product_image(['size'=>'xs']) }}" alt="Product"></a>
                            </div>
                            <div class="item-content p-3">
                                <h3 class="item-title"><a href="{{ $product->url() }}">{{ $product->title }}</a></h3>
                                <ul class="entry-meta" dir="rtl">
                                    {{-- <li><i class="far fa-clock"></i>{{ $product->created_at->diffForHumans() }}</li> --}}
                                    {{-- <li class="d-inline">
                                        <i class="fas fa-tags"></i>
                                        @if($product->category)
                                            <a href="{{ $product->category->url() }}">{{ $product->category->name }}</a>
                                        @endif
                                    </li> --}}
                                    @if ($product->price)
                                        <li class="d-inline text-secondary" style="font-size: 18px;">
                                            {{-- <i class="fas fa-money-bill"></i> --}}
                                            <span>{{ $product->local_price() }}</span>
                                            <small><span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span></small>
                                            
                                            @if($product->price < $product->initial_price)
                                                <del class="small text-muted">
                                                    {{ $product->local_initial_price() }}
                                                    <span class="currency-symbol">{{ country()->currency->symbol }}</span>
                                                </del>
                                            @endif
                                        </li>
                                    @endif
                                </ul>
                                
                                <form method="post" class="cart-form mt-2">
                                    <input type="hidden" value="1" class="quantity" name="demo_vertical2"/>
                                    <input type="hidden" value="{{ $product->id }}" class="product-id">
                                    <button class="btn btn-info btn-block text-center py-2" type="submit">
                                        <i class="fa fa-cart-plus ml-1"></i> إضافة لعربة التسوق
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="product-list-view">
                    <div class="list-view-layout2">
                        <div class="product-box-layout3">
                            <div class="item-img">
                                <a href="{{ $product->url() }}"><img src="{{ $product->product_image(['size'=>'xs']) }}" alt="Product"></a>
                            </div>
                            <div class="product-info">
                                <div class="item-content">
                                    <h3 class="item-title"><a href="{{ $product->url() }}">{{ $product->title }}</a></h3>
                                    <ul class="entry-meta">
                                        <li><i class="far fa-clock"></i>{{ $product->created_at->diffForHumans() }}</li>
                                        <li>
                                            <i class="fas fa-tags"></i>
                                            @if($product->category)
                                                <a href="{{ $product->category->url() }}">{{ $product->category->name }}</a>
                                            @endif
                                        </li>
                                    </ul>
                                    <p>{{ Str::limit( strip_tags($product->description), 230, '...') }}</p>

                                </div>
                                <div class="item-right float-left" style="min-width: 130px; max-width: 150px; display: grid;">
                                    <div class="right-meta">
                                        {{-- <span><i class="far fa-eye"></i>{{ $product->views }} مشاهدة</span> --}}
                                    </div>
                                    <div class="item-btn">
                                        <a href="{{ $product->url() }}" class="btn-block px-1">تفاصيل المنتج</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <?php $msg = 'لم يتم نشر أي منتجات حتى الآن !'; ?>
            <?php 
                if(request()->categories || request()->sub_categories)
                    $msg = 'لم يتم إيجاد أي منتجات <br><a href="/products">إزالة كافة الفلاتر</a>'; 
            ?>
            @include('main.layouts.partials.empty')
        @endforelse
    </div>
</div>

{{ $products->onEachSide(1)->links() }}
            