@if(App\Models\Category::whereNull('category_id')->count() && (request()->page && request()->page%3 == 0) )
    <section class="mt-3 mb-4 py-3 px-2 d-flex align-items-center d-lg-none" style="overflow-x: auto; background: #fff; box-shadow: 0 0 13px 7px #fff; width: 100%;">
        @foreach(App\Models\Category::whereNull('category_id')->limit(7)->inRandomOrder()->get() as $category)
            <a href="/listings?categories[]={{ $category->id }}" style="font-size: 1.1rem;">
                <div class="badge text-muted mx-2 py-4 px-3" style="font-weight: normal; background: #f5f7fa; min-width: 150px;">
                    <i class="d-block text-red {{ $category->icon }}" style="font-size: 22px;"></i>
                    <span class="d-block mt-3 mb-3" style="font-size: 15px;">{{ $category->name }}</span>
                    <div class="item-count small">{{ $category->listings()->count() * 23 }} إعلان</div>
                </div>
            </a>
        @endforeach
    </section>
@endif
