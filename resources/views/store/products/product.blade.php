<?php
    $options = [];
    $vs = [];
    $added_values = [];
    $used_ps = [];
    foreach ($product->options['values'] as $value) {
        $option = optional(App\Models\OptionValue::find($value))->option_id;
        $ps = App\Models\Product::whereGroup($product->group)->whereJsonContains('options->options', $option);
        if($vs) $ps = $ps->whereJsonContains('options->values', $vs);
        $ps = $ps->get();
        $vs[] = $value;
        foreach ($ps as $p) {
            foreach ($p->options['values'] as $v) {
                $v = App\Models\OptionValue::find($v);
                if($v && $v->option_id == $option && !in_array($v->id, $added_values)){
                    $value = [];
                    $value['value'] = $v;
                    $value['url'] = $p->url();
                    $options[$option][] = $value;
                    $added_values[] = $v->id;
                    $used_ps[] = $p->id;
                }
            }
        }
    }
    $related_ps = sizeof($options)>1 || App\Models\Product::whereGroup($product->group)->count() == 1 ?  App\Models\Product::whereId(0): 
        App\Models\Product::whereGroup($product->group)->whereNotIn('id', $used_ps)->get();
?>
@extends('store.layouts.store')

@section('title', 'معاينة المنتج | '. $product->title)

@section('head')
    <link rel="stylesheet" type="text/css" href="/assets/plugins/fancybox-master/jquery.fancybox.min.css">
    <style>
        .cart-form button { border-radius: 0; padding: 20px; }
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
                        <h1>{{ $product->title }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/products">المنتجات</a> </li>
                            <li>معاينة المنتج</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--=====================================-->
    <!--=          Product Start         =-->
    <!--=====================================-->
    <section class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="single-product-box-layout1">
                        <div class="product-info light-shadow-bg">
                            <div class="product-content light-box-content">

                                @include('store.products.partials.product-images')

                                <div class="single-entry-meta">
                                    <ul>
                                        {{-- <li>
                                            <i class="far fa-clock"></i>
                                            {{ $product->created_at->diffForHumans() }}
                                        </li> --}}
                                        <li>
                                            <i class="fas fa-tags"></i>
                                            @if($product->category)
                                                <a href="{{ $product->category->url() }}">{{ $product->category->name }}</a>
                                            @endif
                                        </li>
                                        {{-- <li><i class="far fa-eye"></i>{{ $product->views }} مشاهدة</li> --}}
                                    </ul>
                                </div>
                                <div class="item-details text-break">
                                    <div class="tab-content pt-0">
                                        <div class="tab-pane fade show active" id="details" role="tabpanel">









                                            {{-- Options --}}
                                            @foreach ($options as $option => $values)
                                            @php
                                                // dd($values);
                                            @endphp
                                                @if ($option = App\Models\Option::find($option))
                                                    <div class="mb-2">
                                                        <strong class="mb-1 ml-2">{{ $option->name }} :</strong>
                                                        @foreach ($values as $value)
                                                            @php
                                                                $option_value = $value['value']
                                                            @endphp
                                                            @if (sizeof($values) == 1)
                                                                <span>{{ $option_value->name }}</span>
                                                            @elseif (in_array($option_value->id, $product->options['values']))
                                                                <span class="btn btn-sm btn-secondary">{{ $option_value->name }}</span>
                                                            @else
                                                                <a href="{{ $value['url'] }}" class="btn btn-sm btn-default">{{ $option_value->name }}</a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach





                                            <p>{{ $product->description }}</p>
                                            @php
                                                $data = json_decode($product->data, true);
                                            @endphp
                                            @if (is_array($data))
                                                <div class="mt-2 mb-3">
                                                    @foreach (json_decode($product->data, true) as $key => $field)
                                                        @if (!empty($field))
                                                            <p style="font-size: 15px;" class="mb-1"><strong>{{ __($key) }}: </strong> <span>{{ __($field) }}</span></p>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            @if ($related_ps->count())
                                                <div class="card">
                                                    <div class="card-body">
                                                        <strong>إختيارات أخرى : </strong> <br>
                                                        @foreach ($related_ps as $p)
                                                            <a href="{{ $p->url() }}">
                                                                {{ $p->title }}
                                                                @foreach ($p->options['values'] as $oval)
                                                                    @php
                                                                        $oval = App\Models\OptionValue::find($oval);
                                                                    @endphp
                                                                    <span class="badge badge-info">{{ $oval->name }}</span>
                                                                @endforeach
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                        @if(!empty(trim($product->address)))
                                            <div class="mt-3 mb-4"> <strong>العنوان تفصيلي:</strong> {{ $product->address }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="item-action-area">
                                    <ul>
                                        <li class="item-social">
                                            <span class="share-title">
                                                <i class="fas fa-share-alt"></i> مشاركة:
                                            </span>
                                            <a href="#" class="bg-facebook open-share"><i class="fa fa-share-alt"></i></a>
                                            <?php $url = config('app.url').$product->url() ?>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" class="bg-facebook"><i class="fab fa-facebook-f"></i></a>
                                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}" class="bg-twitter"><i class="fab fa-twitter"></i></a>
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($url) }}&source=LinkedIn" class="bg-linkedin"><i class="fab fa-linkedin-in"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @include('store.products.partials.related-products')
                    </div>
                </div>
                
                <div class="col-xl-3 col-lg-4 sidebar-break-md sidebar-widget-area">
                    <div class="widget-lg widget-author-info widget-light-bg">
                        <div class="author-content">
                            @if ($product->price !== null)
                                <div class="widget-lg widget-price mb-3">
                                    <div class="item-price text-center">
                                        {{ $product->local_price() }}
                                        <small><span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span></small>
                                        
                                        @if($product->price < $product->initial_price)
                                            <small>
                                                <del class="small">
                                                    {{ $product->local_initial_price() }}
                                                    <small><span class="currency-symbol">{{ country()->currency->symbol }}</span></small>
                                                </del>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <form method="post" class="cart-form">
                                <input type="hidden" value="1" class="quantity" name="demo_vertical2"/>
                                <input type="hidden" value="{{ $product->id }}" class="product-id">
                                <button class="btn btn-info btn-block text-right" type="submit">
                                    <i class="fa fa-cart-plus"></i> إضافة لعربة التسوق
                                </button>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- Fancybox -->
    <script src="/assets/plugins/fancybox-master/jquery.fancybox.min.js"></script>
    <script>
        $('[data-fancybox]').fancybox();
    </script>
    <script src="/assets/js/ajax/ajax.js"></script>
    <script src="/assets/js/ajax/comment.js?V=1.1"></script>
    <script>
        $(document).ready(function(){
            if (!navigator.share) {
                $('.open-share').hide();
            }
            $('.open-share').on('click', function(e){
                e.preventDefault();
                if (navigator.share) {
                    navigator.share({
                        title: document.title,
                        text: "سوق نشمي",
                        url: window.location.href
                    }).then(() => console.log('Successful share'))
                    .catch(error => console.log('Error sharing:', error));
                }
            });
        });
    </script>
@endsection