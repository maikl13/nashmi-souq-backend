@extends('main.layouts.main')

@section('title', "طلب #". $order->uid)

@section('content')

    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>طلب #{{ $order->uid }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/my-orders">الطلبات</a> </li>
                            <li>طلب #{{ $order->uid }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="single-product-wrap-layout1 product-box-layout3 section-padding-equal-70 bg-accent">
        <div class="container mt-5">
            <div class="px-4 pt-4 pb-1 bg-white mb-3">
                <div class="section-head inner-haed">
                    <h3 class="pb-1" style="line-height: 35px">
                        <div class="float-left">
                            <span class="float-right">{{ $order->price() }} 
                                <span class="currency-symbol" title="ب{{ $order->currency->name }}">{{ $order->currency->symbol }}</span>
                            </span>
                        </div>
                        <span>طلب #{{ $order->uid }} </span><br>
                        
                        <div class="product-info">
                            <div class="item-content">
                                <ul class="entry-meta d-block">
                                    <li><i class="far fa-clock"></i> {{ $order->created_at->format('M d, Y') }}</li>
                                    <li>
                                        <i class="fas fa-money-bill"></i>
                                        <span>وسيلة الدفع : </span>{{ $order->payment_method() }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </h3>
                </div>

                @foreach ($order->packages as $i => $package)
                    <div class="package mb-3 p-3" style="background: #fafafa; box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);">
                        <i>الشحنة {{ $i+1 }} من {{ $order->packages()->count() }} - <small>{{ $package->status() }}</small></i>
                        <br>
                        البائع: <a href="{{ $package->store->url() }}">{{ $package->store->store_name() }}</a>
                        <div class="section-content">
                            {{-- @if( $package->is_approved() )
                                <div class="alert alert-info text-center py-4" style="line-height: 30px;">
                                    <strong>طلبك قيد المراجعة</strong><br>
                                    <span>بإنتظار تأكيدك للطلب و رسوم الشحن للبدء بتجهيز الطلب.</span>
                                </div>
                            @endif --}}
                            @if( $package->seller_note() )
                                <div class="alert alert-info text-center py-4" style="line-height: 30px;">
                                    <strong>ملاحظة البائع</strong><br> 
                                    <span>{{ $package->seller_note() }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="row mt-4 pt-3">
                            @include('main.store.partials.package-status')
                        </div>
                        <div class="mt-4 pt-3">
                            <?php $for_client = true; ?>
                            @include('main.store.partials.package-details')
                        </div>
                        <div class="alert alert-secondary text-center py-3 mt-3" style="line-height: 30px;">
                            <strong>حالة الشحنة</strong>: {{ $package->status() }}
                            @if($package->is_cancelled_by_buyer())
                                <form action="/packages/change-status" class="d-inline" method="post">
                                    @csrf
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <input type="hidden" name="package_status" value="backward">
                                    <button type="submit" class="btn btn-sm btn-secondary px-3">تراجع</button>
                                </form>
                            @endif
                        </div>
                        <div class="row py-3">
                            @if( $package->is_pending() )
                                <div class="text-center py-3 col-6">
                                    <a href="#" class="btn btn-block bg-gray text-danger py-3 cancel-package" data-package-id={{ $package->id }}>إلغاء الشحنة</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/assets/js/ajax/ajax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        $(document).on('click', '.cancel-package', function(e){
            e.preventDefault();
            var packageId = $(this).data('package-id');
            Swal.fire({
                title: "هل أنت متأكد!",
                text: "سيتم إلغاء الشحنة {{ $order->is_on_credit_payment() ? 'و سيتم إضافة قيمة الشحنة لرصيد محفظتك' : '' }}",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "لا",
                confirmButtonText: "نعم!"
            }).then((result) => {
                if (result.value) {
                    window.location.href = "/order/"+packageId+"/cancel";
                }
            });
        });
    </script>
@endsection