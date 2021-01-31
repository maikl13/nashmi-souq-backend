@extends('store.layouts.store')

@section('title', 'طلبك قيد المراجعة')

@section('content')
    <!-- contact area -->
    <div class="single-product-wrap-layout1 bg-accent">
        <div class="container py-5">
            <div class="p-2 py-5 bg-white">
                <div class="section-head inner-haed">
                    <h2 class="text-uppercase text-center pb-1 pt-4">طلبك قيد المراجعة</h2>
                </div>
                <div class="section-content">
                    <p class="pb-2 text-center" style="font-size: 17px;">سيتم مراجعة طلبك, و سيتم إعلامك بمجرد قبول الطلب!</p>
                    <p class="py-1 text-center">يمكنك تتبع حالة الطلب من الرابط بالأسفل.</p>
                    <div class="text-center pt-2 pb-5">
                        <a href="{{ route('my-orders', request()->store->store_slug) }}" class="btn btn-primary py-3 px-5">تتبع حالة الطلب</a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
