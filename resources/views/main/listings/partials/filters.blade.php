<div class="col-xl-3 col-lg-4 sidebar-break-md sidebar-widget-area mt-1" id="accordion">
    <div class="widget-bottom-margin-md widget-accordian widget-filter">
        <h3 class="widget-bg-title">فلترة الإعلانات</h3>
        <form action="/listings">
            <div class="accordion-box">
                <div class="card filter-type filter-item-list">
                    <div class="card-header">
                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="false">النوع</a>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <div class="filter-type-content">
                                <?php 
                                    $types = [
                                        App\Models\Listing::TYPE_SELL => 'بيع',
                                        App\Models\Listing::TYPE_BUY => 'شراء',
                                        App\Models\Listing::TYPE_EXCHANGE => 'تبديل',
                                        App\Models\Listing::TYPE_RENT => 'إيجار',
                                        App\Models\Listing::TYPE_JOB => 'عرض وظيفة',
                                        App\Models\Listing::TYPE_JOB_REQUEST => 'طلب وظيفة',
                                    ];
                                ?>
                                @foreach ($types as $key => $type)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="radio{{ $key }}" value="{{ $key }}" {{ request()->type == $key ? 'checked' : '' }}>
                                        <label class="form-check-label mr-1" for="radio{{ $key }}">{{ $type }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card filter-category multi-accordion filter-item-list">
                    <div class="card-header">
                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="false"> الأقسام </a>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <div class="card-body p-3">
                            <div class="multi-accordion-content" id="accordion1">
                                @forelse(App\Models\Category::whereNull('category_id')->get() as $category)
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
                <div class="card filter-location multi-accordion filter-item-list">
                    <div class="card-header">
                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="false"> الموقع </a>
                    </div>
                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <div class="multi-accordion-content" id="accordion2">
                                <?php $states = country() ? country()->states : []; ?>
                                @forelse($states as $state)
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="parent-list py-1 {{ !$state->areas()->count() ? 'single' : '' }}">
                                                <input type="checkbox" name="states[]" id="s_{{ $state->id }}" value="{{ $state->id }}" {{ request()->states && in_array($state->id, request()->states) ? 'checked' : '' }}>
                                                <a class="mr-2 collapsed" role="button" data-toggle="collapse" href="#state{{ $state->id }}" aria-expanded="false" style="color: #646464;">{{ $state->name }}</a>
                                            </div>
                                        </div>

                                        @if($state->areas()->count())
                                            <div id="state{{ $state->id }}" class="mr-3 collapse" data-parent="#accordion2">
                                                <div class="card-body">
                                                    <ul class="sub-list">
                                                        @foreach($state->areas as $area)
                                                            <li>
                                                                <input type="checkbox" name="areas[]" id="sc_{{ $area->id }}" value="{{ $area->id }}" {{ request()->areas && in_array($area->id, request()->areas) ? 'checked' : '' }}>
                                                                <label for="sc_{{ $area->id }}" style="font-size: 15px;">{{ $area->name }}</label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="card">
                                        <div class="card-header">لا يوجد أي مناظق</div>
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

    <div class="row">
        <div class="col mt-2 mb-4 text-center d-none d-md-block">{!! ad('large_rectangle') !!}</div>
    </div>
</div>