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
                <?php $listing = $order->listing; ?>
                <div class="px-4 pt-4 pb-1 bg-white mb-4">
                    <div class="section-head inner-haed">
                        <h3 class="pb-1" style="line-height: 35px">
                            <div class="float-left">
                                <span class="float-right">{{ $order->total_price() }} {{ __('EGP') }}</span>
                            </div>
                            <span class="float-right">{{ $listing->title }}</span>
                            <small class="text-muted mr-2" style="font-size: 15px;">({{ $order->uid }})</small><br>
                            <small class="text-muted" style="font-size: 13px; position: relative; top: -8px;">{{ $order->created_at->format('M d, Y') }}</small>
                            <small class="text-muted" style="font-size: 13px; position: relative; top: -8px;"> - الكمية: {{ $order->quantity }}</small>
                        </h3>
                    </div>
                    <div class="section-content">
                        @if( $order->admin_note() )
                            <div class="alert alert-info"><strong>رسالة الإدارة:</strong> {{ $order->admin_note() }}</div>
                        @endif
                    </div>
                    <div class="row mt-4 pt-3">
                        @include('main.store.partials.order-steps')
                    </div>
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
