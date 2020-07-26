@extends('main.layouts.main')

@section('title', 'فشل الدفع')

@section('content')
    <!-- contact area -->
    <div class="single-product-wrap-layout1 bg-accent">
        <div class="container py-5">
            <div class="p-2 py-5 bg-white">
                <div class="section-head inner-haed">
                    <h2 class="text-uppercase text-center pb-1 pt-4">حدث خطأ ما</h2>
                </div>
                <div class="section-content">
                    <p class="pb-2 text-center" style="font-size: 17px;">عملية الدفع لم تتم بشكل صحيح!</p>
                    <p class="py-1 text-center">من فضلك قم بمراجعة الجهة المصدرة لبطاقتك أو استخدم وسيلة دفع أخرى.</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
