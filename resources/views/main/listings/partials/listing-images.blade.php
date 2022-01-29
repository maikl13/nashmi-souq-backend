<div class="item-img-gallery">
    <div class="tab-content">
        @foreach ($listing->listing_images() as $key => $image)
            <div class="tab-pane fade{{ !$key ? ' w-100 show active' : '' }}" id="gallery{{ $key }}" role="tabpanel">
                <a href="{{ $image }}" data-fancybox="product-images" class="w-100 text-center" style="background-color: #f85c702b;">
                    <img class="zoom_01" src="{{ $image }}" alt="product" data-zoom-image="{{ $image }}" style="max-height: 600px; max-width: 100%;">
                </a>
            </div>
        @endforeach
    </div>
    <ul class="nav nav-tabs" role="tablist">
        {{-- In case if lazy loading integrated later --}}
        {{-- @foreach ($listing->listing_images(['size'=>'xs']) as $key => $image) --}}
        @foreach ($listing->listing_images() as $key => $image)
            <li class="nav-item">
                <a class="mb-2 nav-link{{ !$key ? ' active' : '' }}" data-toggle="tab" href="#gallery{{ $key }}" role="tab" aria-selected="true">
                    <img src="{{ $image }}" alt="thumbnail" style="max-height: 100px;">
                </a>
            </li>
        @endforeach
    </ul>
</div>