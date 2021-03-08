<div class="product-filter-heading">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="item-title">
                @if($listings->total() == 0)
                    إظهار {{ $listings->total() }} إعلان
                @else
                    إظهار {{ $listings->firstItem() }}-{{ $listings->lastItem() }} من {{ $listings->total() }} إعلان
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

<div class="row">
    <div class="col mt-2 mb-4 text-center d-none d-md-block">{!! ad('leaderboard') !!}</div>
    <div class="col mt-2 mb-4 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
</div>

<div id="product-view" class="product-box-grid">
    <div class="row">
        @forelse($listings as $listing)
            <div class="col-xl-4 col-md-6">
                <div class="product-grid-view">
                    <div class="grid-view-layout2">
                        <div class="product-box-layout1 {{ $listing->is_featured() ? 'item-trending' : '' }} {{ $listing->is_fixed() ? 'item-fixed' : '' }}">
                            <div class="item-img">
                                <a href="{{ $listing->url() }}"><img src="{{ $listing->listing_image(['size'=>'xs']) }}" alt="Product"></a>
                            </div>
                            <div class="item-content">
                                <h3 class="item-title"><a href="{{ $listing->url() }}">{{ $listing->title }}</a></h3>
                                <ul class="entry-meta" dir="rtl">
                                    <li><i class="far fa-clock"></i>{{ $listing->created_at->diffForHumans() }}</li>
                                    <li class="d-inline">
                                        <i class="fas fa-map-marker-alt"></i>
                                        @if($listing->state)
                                            <a href="{{ $listing->state->url() }}">{{ $listing->state->name }}</a>
                                        @endif
                                        @if($listing->area)
                                            <a href="{{ $listing->area->url() }}">{{ ', '.$listing->area->name }}</a>
                                        @endif
                                    </li>
                                    <li class="d-inline">
                                        <i class="fas fa-tags"></i>
                                        @if($listing->category)
                                            <a href="{{ $listing->category->url() }}">{{ $listing->category->name }}</a>
                                        @endif
                                    </li>
                                    @if ($listing->price)
                                        <li class="d-inline mr-2">
                                            <i class="fas fa-money-bill"></i>
                                            {{ $listing->price() }}
                                            <span class="currency-symbol" title="ب{{ $listing->currency->name }}">{{ $listing->currency->symbol }}</span>
                                        </li>
                                    @endif
                                </ul>
                                <div class="row mt-2">
                                    @if (auth()->guest() || auth()->user()->id != $listing->user->id)
                                        <div class="col" style="padding: 0 !important;margin: 0 5px !important;white-space: nowrap;">
                                            <a href="{{ Auth::check() ? '#' : route('login') }}" class="main-btn btn-block p-1 {{ Auth::check() ? 'toggle-chat' : '' }}" data-name="{{ $listing->user->store_name() }}" data-logo="{{ $listing->user->store_logo() }}" data-username="{{ $listing->user->username }}" data-listing="{{ $listing->id }}">
                                                <i class="fa fa-envelope"></i> دردش
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col mb-1" style="padding: 0 !important;margin: 0 5px 5px 5px  !important;white-space: nowrap;">
                                        <a href="{{ Auth::check() ? 'tel:'.$listing->user->phone : route('login') }}" class="btn btn-info btn-block">
                                            <i class="fa fa-phone"></i> إتصل
                                        </a>
                                    </div>
                                    <div class="col" style="padding: 0 !important;margin: 0 5px !important;white-space: nowrap;">
                                        <a href="{{ $listing->url() }}#comments" class="btn btn-secondary btn-block">
                                            <i class="fa fa-comments"></i> التعليقات
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-list-view">
                    <div class="list-view-layout2">
                        <div class="product-box-layout3 {{ $listing->is_featured() ? 'item-trending' : '' }} {{ $listing->is_fixed() ? 'item-fixed' : '' }}">
                            <div class="item-img">
                                <a href="{{ $listing->url() }}"><img src="{{ $listing->listing_image(['size'=>'xs']) }}" alt="Product"></a>
                            </div>
                            <div class="product-info">
                                <div class="item-content">
                                    <h3 class="item-title"><a href="{{ $listing->url() }}">{{ $listing->title }}</a></h3>
                                    <ul class="entry-meta">
                                        <li><i class="far fa-clock"></i>{{ $listing->created_at->diffForHumans() }}</li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            @if($listing->state)
                                                <a href="{{ $listing->state->url() }}">{{ $listing->state->name }}</a>
                                            @endif
                                            @if($listing->area)
                                                <a href="{{ $listing->area->url() }}">{{ ', '.$listing->area->name }}</a>
                                            @endif
                                        </li>
                                        <li>
                                            <i class="fas fa-tags"></i>
                                            @if($listing->category)
                                                <a href="{{ $listing->category->url() }}">{{ $listing->category->name }}</a>
                                            @endif
                                        </li>
                                    </ul>
                                    <p>{{ Str::limit( strip_tags($listing->description), 230, '...') }}</p>

                                </div>
                                <div class="item-right float-left" style="min-width: 130px; max-width: 150px; display: grid;">
                                    <div class="right-meta">
                                        {{-- <span><i class="far fa-eye"></i>{{ $listing->views }} مشاهدة</span> --}}
                                    </div>
                                    <div class="item-btn">
                                        <a href="{{ $listing->url() }}" class="btn-block px-1">تفاصيل الإعلان</a>

                                        @if (auth()->guest() || auth()->user()->id != $listing->user->id)
                                            <a href="{{ Auth::check() ? '#' : route('login') }}" class="btn-block {{ Auth::check() ? 'toggle-chat' : '' }}" data-name="{{ $listing->user->store_name() }}" data-logo="{{ $listing->user->store_logo() }}" data-username="{{ $listing->user->username }}" data-listing="{{ $listing->id }}">
                                                <i class="fa fa-envelope"></i> دردش</a>
                                        @endif
                                            <a href="{{ $listing->url() }}#comments" class="btn-block px-1">
                                                <i class="fa fa-comments"></i> تعليق
                                            </a>
                                        <a href="{{ Auth::check() ? 'tel:'.$listing->user->phone : route('login') }}" class="btn-block px-1"><i class="fa fa-phone"></i> إتصل</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <?php $msg = 'لم يتم نشر أي إعلانات حتى الآن !'; ?>
            <?php 
                if(request()->categories || request()->sub_categories || request()->states || request()->areas)
                    $msg = 'لم يتم إيجاد أي إعلانات <br><a href="/listings">إزالة كافة الفلاتر</a>'; 
            ?>
            @include('main.layouts.partials.empty')
        @endforelse
    </div>
</div>

<div class="row">
    <div class="col mt-3 text-center d-none d-md-block">{!! ad('leaderboard') !!}</div>
    <div class="col mt-3 text-center d-block d-md-none">{!! ad('mobile_banner') !!}</div>
</div>

{{ $listings->onEachSide(1)->links() }}
            