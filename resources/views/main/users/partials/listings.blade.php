<div class="tab-pane fade" id="my-listing" role="tabpanel">
    <div class="myaccount-listing">
        <div class="list-view-layout1">
            @forelse(Auth::user()->listings()->latest()->get() as $listing)
                <div class="product-box-layout3 deletable">
                    <div class="item-img">
                        <a href="{{ $listing->url() }}"><img src="{{ $listing->listing_image() }}" alt="Product"></a>
                    </div>
                    <div class="product-info">
                        <div class="item-content">
                            <h3 class="item-title"><a href="{{ $listing->url() }}">{{ $listing->title }}</a></h3>
                            <ul class="entry-meta">
                                <li>
                                    <i class="far fa-clock"></i>
                                    {{ $listing->created_at->diffForHumans() }}
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    @if($listing->state)
                                        <a href="{{ $listing->state->url() }}">{{ $listing->state->name }}</a>
                                    @endif
                                    @if($listing->area)
                                        <a href="{{ $listing->area->url() }}">{{ ', '.$listing->area->name }}</a>
                                    @endif
                                </li>
                                <li>
                                    <i class="fas fa-tags"></i>
                                    @if($listing->category)
                                        <a href="{{ $listing->category->url() }}">{{ $listing->category->name }}</a>
                                    @endif
                                </li>
                                <li><i class="far fa-eye"></i>{{ $listing->views }} مشاهدة</li>
                            </ul>
                            <ul class="item-condition">
                                <li>{{ Str::limit( strip_tags($listing->description), 50, '...') }}</li>
                            </ul>
                            <div class="btn-group">
                                <a href="{{ $listing->url() }}/edit">تعديل</a>
                                <a class="delete" href="{{ $listing->url() }}">حذف</a>
                                <a href="{{ $listing->url() }}">معاينة</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <?php
                    $msg = 'لم تقم بإضافة أي إعلانات حتى الآن <br>';
                    $msg .= '<a href="/listings/add" class="btn btn-danger mt-3 py-2 px-4" style="opacity: .7;">قم بإضافة إعلان</a>';
                ?>
                @include('main.layouts.partials.empty')
            @endforelse
        </div>
    </div>
</div>