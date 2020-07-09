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

    <div class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
        <div class="container mt-5">
            <div class="px-4 pt-4 pb-1 bg-white mb-3">
                <div class="section-head inner-haed">
                    <h3 class="pb-1" style="line-height: 35px">
                        <div class="float-left">
                            <span class="float-right">{{ $order->price + $order->taxes + $order->shipping }} {{ __('EGP') }}</span>
                        </div>
                        <span>طلب #{{ $order->uid }} </span> - <small>{{ $order->status() }}</small><br>
                        <small class="text-muted" style="font-size: 13px; position: relative; top: -8px;">{{ $order->created_at->format('M d, Y') }}</small>
                    </h3>
                </div>
                <div class="section-content">
                    @if( $order->is_approved() )
                        <div class="alert alert-primary text-center py-4" style="line-height: 30px;">
                            <h4>طلبك قيد المراجعة</h4>
                            <span>بإنتظار تأكيدك للطلب و رسوم الشحن للبدء بتجهيز الطلب.</span>
                        </div>
                    @endif
                    @if( $order->admin_note() )
                        <div class="alert alert-info text-center py-3" style="line-height: 30px;"><strong>ملاحظة البائع</strong><br> {{ $order->admin_note() }}</div>
                    @endif
                </div>
                <div class="mt-4 pt-3">
                    <?php $for_client = true; ?>
                    @include('main.store.partials.order-details')
                </div>
                <div class="row mt-4 pt-3">
                    @include('main.store.partials.order-steps')
                </div>

                <div class="alert alert-secondary text-center py-3" style="line-height: 30px;">
                    <strong>حالة الطلب</strong>: {{ $order->status() }}
                    @if($order->is_cancelled_by_buyer())
                        <form action="/orders/change-status" class="d-inline" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="order_status" value="backward">
                            <button type="submit" class="btn btn-sm btn-secondary px-3">تراجع</button>
                        </form>
                    @endif
                </div>
                <div class="row py-3">
                    @if( $order->is_approved() )
                        <div class="text-center py-3 col-6">
                            <a href="/order/{{ $order->id }}/confirm" class="btn btn-primary btn-block py-3 px-5">تأكيد الطلب</a>
                        </div>
                    @endif
                    @if( $order->is_pending() || $order->is_approved() )
                        <div class="text-center py-3 col-6">
                            <a href="#" class="btn btn-block bg-gray text-danger py-3 cancel-order" data-order-id={{ $order->id }}>إلغاء الطلب</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/assets/js/ajax/ajax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        $(document).on('click', '.cancel-order', function(e){
            e.preventDefault();
            var ordertId = $(this).data('order-id');
            Swal.fire({
                title: "هل أنت متأكد!",
                text: "سيتم إلغاء الطلب",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "لا",
                confirmButtonText: "نعم!"
            }).then((result) => {
                if (result.value) {
                    window.location.href = "/order/"+ordertId+"/cancel";
                }
            });
        });
    </script>
@endsection