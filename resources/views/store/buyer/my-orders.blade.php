@extends('main.layouts.main')

@section('title', 'طلباتي')

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>طلباتي</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>طلباتي</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
        <div class="container mt-5">
            @forelse ($orders as $order)
                <div class="px-4 pt-4 pb-1 bg-white mb-4">
                    <div class="section-head inner-haed">
                        <h3 class="pb-1" style="line-height: 35px">
                            <div class="float-left">
                                <span class="float-right">{{ $order->price() }} 
                                    <span class="currency-symbol" title="ب{{ $order->currency->name }}">{{ $order->currency->symbol }}</span>
                                </span>
                            </div>
                            <span>الطلب #{{ $order->uid }}</span>
                        </h3>
                        <small class="text-muted" style="font-size: 13px; position: relative; top: -23px;">{{ $order->created_at->format('M d, Y') }}</small>
                        @foreach ($order->packages as $i => $package)
                            <div class="package mb-3">
                                <small>
                                    <i>الشحنة {{ $i+1 }} من {{ $order->packages()->count() }} ({{ $package->status() }})</i>
                                    <br>
                                    البائع: <a href="{{ $package->store->url() }}">{{ $package->store->store_name() }}</a>
                                </small>
                                @foreach ($package->package_items as $item)
                                    <div class="package-item" dir="rtl">
                                        <?php $listing = $item->listing; ?>
                                        <img src="{{ $listing->listing_image(['size'=>'xxs']) }}" width="70" alt="Product Image" class="m-2">
                                        <a href="{{ $listing->url() }}" style="color: #666;">{{ $listing->title }}</span>
                                        {{-- <small class="text-muted mr-2" style="font-size: 15px;">({{ $order->uid }})</small><br> --}}
                                        <small class="text-muted" style="font-size: 13px;">الكمية: {{ $item->quantity }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    {{-- <div class="section-content">
                        @if( $order->admin_note() )
                            <div class="alert alert-info"><strong>رسالة الإدارة:</strong> {{ $order->admin_note() }}</div>
                        @endif
                    </div> --}}
                    {{-- <div class="row mt-4 pt-3">
                        @include('store.partials.order-steps')
                    </div> --}}
                    <div class="clearfix"></div>
                    <div class="text-center py-3 header-btn">
                        <a href="{{ route('order-details', $order->id) }}" class="item-btn w-100 d-block py-3 px-5 rounded-0">
                            عرض تفاصيل الطلب
                        </a>
                    </div>
                </div>
            @empty
                @include('main.layouts.partials.empty')
            @endforelse

            {{ $orders->links() }}
        </div>
    </div>
@endsection
