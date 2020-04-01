<div class="col-xl-3 col-lg-4 sidebar-break-md sidebar-widget-area" id="accordion">
    <div class="widget-bottom-margin-md widget-accordian widget-filter">
        <h3 class="widget-bg-title">فلترة الإعلانات</h3>
        <form action="#">
            <div class="accordion-box">
                <div class="card filter-type filter-item-list">
                    <div class="card-header">
                        <a class="parent-list" role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true">النوع</a>
                    </div>
                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            <div class="filter-type-content">
                                <ul>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="radioexample" id="radio1" value="Sell">
                                        <label class="form-check-label" for="radio1">بيع</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="radioexample" id="radio2" value="Buy">
                                        <label class="form-check-label" for="radio2">شراء</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="radioexample" id="radio3" value="Exchange">
                                        <label class="form-check-label" for="radio3">تبديل</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="radioexample" id="radio4" value="Job">
                                        <label class="form-check-label" for="radio4">وظيفة</label>
                                    </li>
                                    <li class="form-check">
                                        <input class="form-check-input" type="radio" name="radioexample" id="radio5" value="To-Let">
                                        <label class="form-check-label" for="radio5">إيجار</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card filter-category multi-accordion filter-item-list">
                    <div class="card-header">
                        <a class="parent-list" role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="true"> الأقسام </a>
                    </div>
                    <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            <div class="multi-accordion-content" id="accordion2">
                                @forelse(App\Models\Category::get() as $category)
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="parent-list {{ !$category->sub_categories()->count() ? 'single' : '' }} collapsed" role="button" data-toggle="collapse" href="#category{{ $category->id }}" aria-expanded="false">
                                                {{ $category->name }}
                                            </a>
                                        </div>
                                        @if($category->sub_categories()->count())
                                            <div id="category{{ $category->id }}" class="collapse" data-parent="#accordion2">
                                                <div class="card-body">
                                                    <ul class="sub-list">
                                                        @foreach($category->sub_categories as $sub_category)
                                                            <li><a href="#">{{ $sub_category->name }}</a></li>
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
                        <a class="parent-list" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="true"> الموقع </a>
                    </div>
                    <div id="collapseThree" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            <div class="multi-accordion-content" id="accordion3">
                                @forelse(Auth::user()->country->states as $state)
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="parent-list {{ !$state->areas()->count() ? 'single' : '' }} collapsed" role="button" data-toggle="collapse" href="#state{{ $state->id }}" aria-expanded="false">
                                                {{ $state->name }}
                                            </a>
                                        </div>
                                        @if($state->areas()->count())
                                            <div id="state{{ $state->id }}" class="collapse" data-parent="#accordion2">
                                                <div class="card-body">
                                                    <ul class="sub-list">
                                                        @foreach($state->areas as $sub_category)
                                                            <li><a href="#">{{ $sub_category->name }}</a></li>
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
                    <div id="collapseFour" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            <div class="price-range-content">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <button type="submit" class="filter-btn">Apply Filters</button>
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