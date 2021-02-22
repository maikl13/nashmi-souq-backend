@extends('store.layouts.store')

@section('title', 'لقد قمت بالإشتراك بنجاح')

@section('content')
    <!-- contact area -->
    <div class="single-product-wrap-layout1 bg-accent">
        <div class="container py-5">
            <div class="p-2 py-5 bg-white">
                <div class="section-head inner-haed">
                    <h1 class="text-center text-success mb-0"><i class="fa fa-check-circle"></i></h1>
                    <h3 class="text-uppercase text-center pb-1 pt-4">عملية الدفع ناجحة</h3>
                </div>
                <div class="section-content">
                    <p class="pt-2 text-center" style="font-size: 19px;">مبروك لقد قمت بالإشتراك بنجاح</p>
                    <p class="py-1 text-center" style="font-size: 17px;">يمكنك البدء بمزاولة نشاطك التجاري و تلقي الطلبات بدءا من الآن!</p>
                    <div class="text-center pt-2 pb-5">
                        <a href="{{ route('store-dashboard', request()->store->store_slug) }}" class="btn btn-primary py-3 px-5">إدارة المتجر</a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
