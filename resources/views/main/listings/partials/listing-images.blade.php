<div class="item-img-gallery">
    <div class="tab-content">
        @foreach ($listing->listing_images() as $key => $image)
            <div class="tab-pane fade{{ !$key ? ' w-100 show active' : '' }}" id="gallery{{ $key }}" role="tabpanel">
                <a href="{{ $image }}" data-fancybox="product-images" class="w-100">
                    <img class="zoom_01 w-100 h-100" src="{{ $image }}" alt="product" data-zoom-image="{{ $image }}">
                </a>
            </div>
        @endforeach
    </div>
    <ul class="nav nav-tabs" role="tablist">
        @foreach ($listing->listing_images() as $key => $image)
            <li class="nav-item">
                <a class="mb-2 nav-link{{ !$key ? ' active' : '' }}" data-toggle="tab" href="#gallery{{ $key }}" role="tab" aria-selected="true">
                    <img src="{{ $image }}" alt="thumbnail">
                </a>
            </li>
        @endforeach
    </ul>
</div>