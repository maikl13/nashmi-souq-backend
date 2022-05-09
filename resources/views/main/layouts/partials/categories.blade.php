@if(App\Models\Category::whereNull('category_id')->count())
    <section class="section-padding-top-heading">
        <div class="container">
            <div class="heading-layout1">
                <h2 class="heading-title">أشهر الأقسام</h2>
            </div>
            
            {{-- ad spaces --}}
            <div class="row mb-4">
                @foreach (ads('leaderboard', 2, true) as $ad)
                    <div class="col-md-6 mb-3 text-center d-none d-md-block">{!! $ad !!}</div>
                @endforeach
                @foreach (ads('mobile_banner', 2, true) as $ad)
                    <div class="col-md-6 mb-3 text-center d-block d-md-none">{!! $ad !!}</div>
                @endforeach
            </div>

            <div class="row">
                @foreach(App\Models\Category::whereNull('category_id')->limit(8)->inRandomOrder()->get() as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="category-box-layout1">
                            <a href="/listings?categories[]={{ $category->id }}">
                                <div class="item-icon">
                                    <i class="{{ $category->icon }}"></i>
                                </div>
                                <div class="item-content">
                                    <h3 class="item-title">{{ $category->name }}</h3>
                                    <div class="item-count">{{ $category->listings()->count() * 43 }} إعلان</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif