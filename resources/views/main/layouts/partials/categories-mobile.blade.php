@if(App\Models\Category::whereNull('category_id')->count() && (request()->page && request()->page%3 == 0) )
    <section class="mt-1 mb-3 py-3 px-2 d-flex align-items-center d-lg-none" style="overflow-x: auto; background: #fefeff; box-shadow: 0 0 12px 3px #fefeff; width: 100%;">
        {{-- <span class="text-muted small" style="flex-shrink: 0;">المزيد :</span>  --}}

        @foreach(App\Models\Category::whereNull('category_id')->limit(10)->inRandomOrder()->get() as $category)
            <a href="/listings?categories[]={{ $category->id }}" style="font-size: 1.1rem;">
                <div class="badge text-muted mx-1 py-4 px-3 shadow-sm" style="font-weight: normal; background: #f5f7fa;">
                    <i class="d-block {{ $category->icon }}"></i>
                    <span class="d-block mt-3 mb-2">{{ $category->name }}</span>
                    <div class="item-count small">{{ $category->listings()->count() * 43 }} إعلان</div>
                </div>
            </a>
        @endforeach
    </section>
@endif
