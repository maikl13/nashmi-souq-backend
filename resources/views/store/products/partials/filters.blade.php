<div class="col-xl-3 col-lg-4 sidebar-break-md sidebar-widget-area" id="accordion">
    <div class="widget-bottom-margin-md widget-accordian widget-filter">
        <h3 class="widget-bg-title">فلترة المنتجات</h3>
        <form action="/products">
            <div class="accordion-box">
                <div class="card filter-category multi-accordion filter-item-list">
                    <div class="card-header">
                        <a class="parent-list" role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="false"> الأقسام </a>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <div class="card-body p-3">
                            <div class="multi-accordion-content" id="accordion1">
                                @forelse(App\Models\Category::whereNull('category_id')->whereIn('id', request()->store->store_categories)->get() as $category)
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="parent-list py-1 {{ !$category->children()->count() ? 'single' : '' }}">
                                                <input type="checkbox" name="categories[]" id="c_{{ $category->id }}" value="{{ $category->id }}" {{ request()->categories && in_array($category->id, request()->categories) ? 'checked' : '' }}>
                                                <a class="mr-2 collapsed" role="button" data-toggle="collapse" href="#category{{ $category->id }}" aria-expanded="false" style="color: #646464;">{{ $category->name }}</a>
                                            </div>
                                        </div>

                                        @if($category->children()->count())
                                            <div id="category{{ $category->id }}" class="mr-1 collapse" data-parent="#accordion1">
                                                <div class="card-body">
                                                    <ul class="sub-list">
                                                        @foreach($category->all_children() as $sub_category)
                                                            <li style="padding-right: {{ ($sub_category->level()-1)*8 }}px;">
                                                                <input type="checkbox" name="sub_categories[]" id="sc_{{ $sub_category->id }}" value="{{ $sub_category->id }}" {{ request()->sub_categories && in_array($sub_category->id, request()->sub_categories) ? 'checked' : '' }}>
                                                                <label for="sc_{{ $sub_category->id }}" style="font-size: 15px;">{{ $sub_category->name }}</label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="card">
                                        <div class="card-header">لا يوجد أي أقسام</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card filter-price-range filter-item-list">
                    <div id="collapseFour" class="" data-parent="">
                        <div class="card-body">
                            <div class="price-range-content">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <button type="submit" class="filter-btn">فلترة</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>