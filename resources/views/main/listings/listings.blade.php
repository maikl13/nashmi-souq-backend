@extends('main.layouts.main')

<?php $title = request()->q ? 'نتائج البحث عن - '.request()->q : 'أحدث الإعلانات'; ?>
@section('title', $title)

@section('head')
    <link rel="stylesheet" type="text/css" href="/assets/plugins/labelauty/source/jquery-labelauty.css">
    <style type="text/css">
        body { background-color: #f5f7fa; }
        input.labelauty+label span.labelauty-checked-image,
        input.labelauty+label span.labelauty-unchecked-image{
            width:8px; height:8px; background-size:contain
        }
        input.labelauty:checked+label,
        input.labelauty:checked:not([disabled])+label:hover{
            background-color:#ff847b!important;
        }
        input.labelauty+label {
            line-height: 8px !important; 
            display: inline-block; padding: 5px; margin: 0; 
        }
    </style>
@endsection

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>{{ $title }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li>الإعلانات</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!--=====================================-->
    <!--=          Search Box Start         =-->
    <!--=====================================-->
    <section class="bg-accent">
        <div class="container">
            <div class="search-box-wrap-layout3">
                @include('main.layouts.partials.search-box')
            </div>
        </div>
    </section>

    <!--=====================================-->
    <!--=          Product Start         =-->
    <!--=====================================-->
    <section class="product-inner-wrap-layout1 bg-accent">
        <div class="container">
            <div class="row">

                @include('main.listings.partials.filters')
                
                <div class="col-xl-9 col-lg-8">
                    @include('main.listings.partials.listings')                        
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modals')
    @include('main.layouts.partials.search-modals')
@endsection

@section('scripts')
    <script src="/assets/plugins/labelauty/source/jquery-labelauty.js"></script>
    <script>
        $(document).ready(function(){
            $("input[type=checkbox]").labelauty({ label: false });
            $("input[type=radio]").labelauty({ label: false });
        });
    </script>
    <script>
        $(document).on('click', '[data-toggle=collapse]', function(){
            $(this).parent().toggleClass('collapsed');
        });
        $(document).on('hide.bs.collapse', ".multi-accordion-content", function(){
            $(this).find('[aria-expanded=true]').parent().addClass('collapsed')
        });
    </script>
    <script>
        $(document).ready(function(){
            $('input:checked').parents('.collapse').removeClass('collapse');
            $('input:checked').closest('.card').find('.collapsed').removeClass('collapsed');
        });
    </script>
    
    @include('main.layouts.partials.search-box-scripts')
@endsection