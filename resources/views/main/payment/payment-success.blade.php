@extends('main.layouts.main')

@section('title', 'عملية الدفع ناجحة')

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
                    <p class="py-2 text-center">مبروك, لقد تمت عملية الدفع بنجاح.</p>
                    <div class="text-center">
                        <a href="/account#payment" class="btn btn-info px-4 py-2">تفاصيل العمليات المالية</a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
