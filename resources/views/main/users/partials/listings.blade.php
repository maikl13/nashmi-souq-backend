<div class="tab-pane fade" id="my-listing" role="tabpanel">
    <div class="myaccount-listing">
        <div class="list-view-layout1">
            @forelse(Auth::user()->listings()->latest()->get() as $listing)
                <div class="deletable mb-4">
                    <div class="listing-box product-box-layout3 m-0 {{ $listing->is_featured() ? 'item-trending' : '' }} {{ $listing->is_fixed() ? 'item-fixed' : '' }}">
                        <div class="item-img">
                            <a href="{{ $listing->url() }}">
                                <img src="{{ $listing->listing_image() }}" alt="Product">
                            </a>
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

                                    @if ($listing->price)
                                        <li class="item-price">
                                            <i class="fas fa-money-bill"></i>
                                            {{ $listing->price() }}
                                            <span class="currency-symbol" title="ب{{ $listing->country->currency->name }}">{{ $listing->country->currency->symbol }}</span>
                                        </li>
                                    @endif
                                </ul>
                                <ul class="item-condition">
                                    <li>{{ Str::limit( strip_tags($listing->description), 50, '...') }}</li>
                                </ul>
                                <div class="btn-group">
                                    @if ($listing->is_active())
                                        <a href="{{ $listing->url() }}/edit"><i class="fa fa-edit ml-1"></i> تعديل</a>
                                    @endif
                                    <a class="delete" href="{{ $listing->url() }}"><i class="fa fa-trash ml-1"></i> حذف</a>
                                    @if( !$listing->is_featured() )
                                        <a href="{{ $listing->url() }}" style="background: orange;" data-toggle="modal" data-target="#promote" data-listing-id="{{ $listing->id }}" class="promote">
                                            <i class="fa fa-crown ml-2"></i>
                                            <strong style="font-weight: bold;">ترقيه لإعلان مميز</strong>
                                        </a>
                                    @endif
                                    @if( !$listing->is_fixed() )
                                        <a href="{{ $listing->url() }}" style="background: darkcyan;" data-toggle="modal" data-target="#promote2" data-listing-id="{{ $listing->id }}" class="promote2">
                                            <i class="fa fa-gem ml-2"></i>
                                            <strong style="font-weight: bold;">تثبيت الاعلان</strong>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!$listing->is_active() && !empty( trim($listing->note) ))
                        <div style="background-color: #dc354521; font-size: 13px;" class="text-center py-2 px-1">
                            <strong>تم إلغاء تفعيل الإعلان بواسطة الإدارة</strong><br>
                            {!! nl2br(e( $listing->note )) !!}
                        </div>
                    @endif
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