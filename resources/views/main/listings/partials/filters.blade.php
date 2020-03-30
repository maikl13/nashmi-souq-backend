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
                        <a class="parent-list" role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="true">
                            الأقسام
                        </a>
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
                        <a class="parent-list" role="button" data-toggle="collapse" href="#collapseThree" aria-expanded="true">
                            Location
                        </a>
                    </div>
                    <div id="collapseThree" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            <div class="multi-accordion-content" id="accordion3">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#location1" aria-expanded="false">
                                            California (3)
                                        </a>
                                    </div>
                                    <div id="location1" class="collapse" data-parent="#accordion3">
                                        <div class="card-body">
                                            <ul class="sub-list">
                                                <li><a href="#">Bakersfield (1)</a></li>
                                                <li><a href="#">Claremont (1)</a></li>
                                                <li><a href="#">Downey (1)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#location2" aria-expanded="false">
                                            Kansas (3)
                                        </a>
                                    </div>
                                    <div id="location2" class="collapse" data-parent="#accordion3">
                                        <div class="card-body">
                                            <ul class="sub-list">
                                                <li><a href="#">Abilene (1)</a></li>
                                                <li><a href="#">Emporia (1)</a></li>
                                                <li><a href="#">Hutchinson (1)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#location3" aria-expanded="true">
                                            Louisiana (3)
                                        </a>
                                    </div>
                                    <div id="location3" class="collapse" data-parent="#accordion3">
                                        <div class="card-body">
                                            <ul class="sub-list">
                                                <li><a href="#">Bogalusa (1)</a></li>
                                                <li><a href="#">Monroe (1)</a></li>
                                                <li><a href="#">New Orleans (1)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#location4" aria-expanded="true">
                                            New Jersey (3)
                                        </a>
                                    </div>
                                    <div id="location4" class="collapse" data-parent="#accordion3">
                                        <div class="card-body">
                                            <ul class="sub-list">
                                                <li><a href="#">Bloomfield (1)</a></li>
                                                <li><a href="#">Cape May (1)</a></li>
                                                <li><a href="#">Englewood (1)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="parent-list collapsed" role="button" data-toggle="collapse" href="#location5" aria-expanded="true">
                                            New York (4)
                                        </a>
                                    </div>
                                    <div id="location5" class="collapse" data-parent="#accordion3">
                                        <div class="card-body">
                                            <ul class="sub-list">
                                                <li><a href="#">Brooklyn (1)</a></li>
                                                <li><a href="#">Mineola (1)</a></li>
                                                <li><a href="#">Port Chester (2)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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