<div class="modal fade" id="promote" tabindex="-1" role="dialog"  aria-hidden="true" dir="rtl">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h6 class="modal-title"> <strong>ترقية لإعلان مميز</strong> </h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/countries/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body" dir="rtl">
					
					<div class="alert alert-info">
						<div class="media">
							<h3 class="pl-3 pt-2"><i class="fa fa-crown text-info"></i></h3>
							<div class="media-body">
								ترقية إعلانك لإعلان مميز يضمن حصولك على أضعاف المشاهدات حيث ستزيد نسبة ظهور إعلانك في الصفحة الرئيسية و في النتائج ذات صلة للإعلانات الأخرى و أيضا سيتصدر إعلانك نتائج البحث
							</div>
						</div>
					</div>
					<div class="alert alert-warning">
						{!! Auth::user()->current_balance() ? "رصيدك الحالي <strong>".Auth::user()->current_balance()."$</strong>, هل أنت بحاجة للمزيد لترقية إعلانك بالشكل المطلوب" : "ليس لديك رصيد بالمحفظة" !!}
						<a href="/balance" class="float-left btn btn-warning btn-sm">
							<i class="fa fa-bolt" style="opacity: .6;"></i> قم بشحن رصيدك الآن 
							<i class="fa fa-bolt" style="opacity: .6;"></i>
						</a>
						<div class="clearfix"></div>
					</div>

					<div class="row pt-3 px-2">
						<div class="px-1 col-xs-12 col-sm-3">
							<input checked type="radio" name="period" aria-label="7 أيام" data-labelauty="7 أيام - 1$" value="employer" class="labelauty"/>
						</div>
						<div class="px-1 col-xs-12 col-sm-3">
							<input type="radio" name="period" aria-label="15 يوم" data-labelauty="15 يوم - 2$" value="employer" class="labelauty"/>
						</div>
						<div class="px-1 col-xs-12 col-sm-3">
							<input type="radio" name="period" aria-label="شهر" data-labelauty="30 يوم - 3$" value="employer" class="labelauty"/>
						</div>
						<div class="px-1 col-xs-12 col-sm-3">
							<input type="radio" name="period" aria-label="شهر" data-labelauty="90 يوم - 7$" value="employer" class="labelauty"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-default ml-1" data-dismiss="modal"> <small>تراجع</small> </button>
					<button type="submit" class="btn bgPrimary text-white px-4"> ترقية الإعلان </button>
				</div>
            </form>
		</div>
	</div>
</div>