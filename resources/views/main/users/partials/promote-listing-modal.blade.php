<div class="modal fade" id="promote" tabindex="-1" role="dialog"  aria-hidden="true" dir="rtl">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h6 class="modal-title"> <strong>ترقية لإعلان مميز</strong> </h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/listings/promote" method="POST" enctype="multipart/form-data" id="promote-form" class="ajax swal-msg" data-on-success="remove_promote_button">
            	@csrf()
            	<input type="hidden" name="listing_id" value="">

				<div class="modal-body" dir="rtl">
					<div class="alert alert-info">
						<div class="media">
							<h3 class="pl-3 pt-2"><i class="fa fa-crown text-info"></i></h3>
							<div class="media-body">
								{!! nl2br(e(setting('featured_ads_benefits'))) !!}
							</div>
						</div>
					</div>
					<div class="alert alert-warning">
						{!! Auth::user()->payout_balance() ? 'رصيدك المتاح حاليا <strong><span class="current-balance">'.Auth::user()->payout_balance()."</span> ". currency()->symbol ."</strong>, هل أنت بحاجة للمزيد لترقية إعلانك بالشكل المطلوب" : "ليس لديك رصيد بالمحفظة" !!}
						<a href="/balance" class="float-left btn btn-warning btn-sm">
							<i class="fa fa-bolt mr-1 ml-2" style="opacity: .6;"></i> قم بشحن رصيدك الآن 
							<i class="fa fa-bolt ml-1 mr-2" style="opacity: .6;"></i>
						</a>
						<div class="clearfix"></div>
					</div>
					<div class="row pt-3 px-2">
						<?php
							$tiers_titles = ['يوم', '3 أيام', 'أسبوع', '15 يوم', 'شهر', '3 شهور', '6 شهور', 'سنة'];
							$tiers = [];
							for ($i=1; $i <= 8; $i++) {
								if(!empty(setting('tier'.$i))) {
									$tier = [];
									$tier['index'] = $i;
									$tier['title'] = $tiers_titles[$i-1];
									$tier['value'] = setting('tier'.$i)+0;
									$tiers[] = $tier;
								}
							}
						?>
						@foreach ($tiers as $key => $tier)
							@if (sizeof($tiers) > 4)
								@if ( 24%sizeof($tiers) == 0)
									<div class="px-1 col-xs-12 col-sm-{{ 24/sizeof($tiers) }}">
								@else
									@if ( $key > sizeof($tiers)/2)
										<div class="px-1 col-xs-12 col-sm-{{ 12/floor(sizeof($tiers)/2) }}">
									@else
										<div class="px-1 col-xs-12 col-sm-{{ 12/ceil(sizeof($tiers)/2) }}">
									@endif
								@endif
							@else
								<div class="px-1 col-xs-12 col-sm-{{ 12%sizeof($tiers) == 0 ? 12/sizeof($tiers) : '4' }}">
							@endif
								@php
									$price = round(exchange($tier['value'], 'USD', currency()->code), 1);
								@endphp
								<input {{ $key == 0 ? 'checked' : '' }} type="radio" data-price="{{ $price }}" data-currency="{{ currency()->symbol }}" name="tier" aria-label="{{ $tier['title'] }}" data-labelauty="{{ $tier['title'] }} - {{ $price }} {{ currency()->symbol }}" value="{{ $tier['index'] }}" class="labelauty"/>
							</div>
						@endforeach
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-default ml-1" data-dismiss="modal"> <small>تراجع</small> </button>
					<button type="button" class="btn bgPrimary text-white px-4 promote-btn"> ترقية الإعلان </button>
				</div>
            </form>
		</div>
	</div>
</div>