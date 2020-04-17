@extends('admin.layouts.admin')

@section('title', "تفاصيل الاعلان - ". $listing->title )

@section('breadcrumb')
	<li class="breadcrumb-item active">تفاصيل الاعلان</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">{{ $listing->title }}</h4>
            <div class="status-badge badge badge-default mx-2">{{ $listing->status() }}</div>
            <div class="float-left">
                <a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#change-status-modal">
                    <i class="fa fa-plus"></i> تغيير حالة الإعلان
                </a>
            </div>
		</div>
		<div class="card-body text-right" dir="rtl">
            <hr>
            <div>
                <img src="{{ $listing->user->store_image() }}" width="40" height="40" alt="author">
                <a href="{{ $listing->user->url() }}">{{ $listing->user->store_name() }}</a>

                @if($listing->user->phone)
                    <div>{{ $listing->user->phone }}</div>
                @endif
            </div>
            <hr>

            <div class="pb-3">
                صور الإعلان <br>
                @foreach ($listing->listing_images() as $key => $image)
                    <a href="{{ $image }}" data-fancybox="listing-images">
                        <img src="{{ $image }}" width="100" style="vertical-align: top;">
                    </a>
                @endforeach
            </div>

            <div class="py-3">
                    <span> تم النشر {{ $listing->created_at->diffForHumans() }}</span> - 
                    <span>
                        @if($listing->state)
                            <a href="{{ $listing->state->url() }}">{{ $listing->state->name }}</a>
                        @endif
                        @if($listing->area)
                            <a href="{{ $listing->area->url() }}">{{ ', '.$listing->area->name }}</a>
                        @endif
                    </span> - 
                    <span>
                        @if($listing->category)
                            <a href="{{ $listing->category->url() }}">{{ $listing->category->name }}</a>
                        @endif
                    </span> - 
                    <span>{{ $listing->views }} مشاهدة</span>
            </div>
            <div><p>{{ $listing->description }}</p></div>

            @if(!empty(trim($listing->address)))
                <div class="mt-4"> <strong>العنوان تفصيلي:</strong> {{ $listing->address }}</div>
            @endif
		</div>
	</div>
@endsection

@section('modals')
    @include('admin.listings.partials.change-status-modal')
@endsection

@section('scripts')
    <script>
        $(document).on('change', '#status', function(){
            $('.note').hide();
            if($('#status').val() == {{ App\Models\Listing::STATUS_INACTIVE }})
                $('.note').show();
        });
    </script>
    <script src="/admin-assets/js/ajax/change-listing-status.js"></script>
@endsection