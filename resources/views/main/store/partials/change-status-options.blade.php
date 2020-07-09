<div class="my-4">
	@include('main.store.partials.order-steps')
</div>

@if( $order->is_pending()  )
	<div class="form-group">
	    <input type="radio" name="order_status" data-labelauty="قبول الطلب" value="approved" class="labelauty" required>
	    <input type="radio" name="order_status" data-labelauty="رفض الطلب" value="rejected" class="labelauty">
	</div>
	<div class="form-group status-details approved-details">
		<label for="shipping" class="form-control-label"> رسوم الشحن <small>بالجنيه المصري</small> :</label>
		<input type="number" step=".01" class="form-control required" id="shipping" value="{{ $order->shipping_method == App\Models\Order::NORMAL_SHIPPING ? '' : 0 }}" name="shipping">
	</div>
	{{-- <div class="form-group status-details rejected-details">
		<label for="rejection_type" class="form-control-label"> نوع الرفض:</label>
		<select name="rejection_type" id="type" class="form-control">
			<option value="1">رفض نهائي</option>
			<option value="2">رفض مؤقت</option>
		</select>
	</div> --}}
	<div class="form-group status-details rejected-details approved-details">
		<label for="note" class="form-control-label"> ملاحظات:</label>
		<textarea name="note" id="note" class="form-control" rows="5" placeholder="ملاحظات ..."></textarea>
	</div>


@elseif( $order->is_deliverable() )
	<div class="form-group">
	    <input type="radio" name="order_status" data-labelauty="الانتقال لمرحلة التسليم" value="prepared" class="labelauty" required>
	    <input type="radio" name="order_status" data-labelauty="الغاء الطلب" value="cancelled" class="labelauty">
	</div>
	<div class="form-group status-details prepared-details cancelled-details">
		<label for="note" class="form-control-label"> ملاحظات:</label>
		<textarea name="note" id="note" class="form-control" rows="5" placeholder="ملاحظات ..."></textarea>
	</div>


@elseif( $order->is_rejected() )
	<div class="form-group">
	    <input type="radio" name="order_status" data-labelauty="تراجع" value="backward" class="labelauty" required>
	    <input type="radio" name="order_status" data-labelauty="{{ $order->is_prepared() ? 'تم التسليم' : 'الانتقال للمرحلة التالية' }}" value="forward" class="labelauty" {{ !$order->is_delivered() ? '' : 'disabled' }}>
	</div>

	<div class="form-group status-details forward-details">
		<label for="shipping" class="form-control-label"> رسوم الشحن <small>بالجنيه المصري</small> :</label>
		<input type="number" step=".01" class="form-control required" id="shipping" value="{{ $order->shipping_method == App\Models\Order::NORMAL_SHIPPING ? '' : 0 }}" name="shipping">
	</div>
	<div class="form-group status-details forward-details">
		<label for="note" class="form-control-label"> ملاحظات:</label>
		<textarea name="note" id="note" class="form-control" rows="5" placeholder="ملاحظات ..."></textarea>
	</div>


@elseif( $order->is_approved() )
	<div class="form-group">
	    <input type="radio" name="order_status" data-labelauty="تراجع" value="backward" class="labelauty" required>
	    @if($order->shipping > 0)
	    	<input type="radio" name="order_status" data-labelauty="بانتظار موافقة المشتري على تكاليف الشحن" value="forward" class="labelauty" disabled>
	    @else
	    	<input type="radio" name="order_status" data-labelauty="الانتقال للمرحلة التالية" value="forward" class="labelauty">
	    @endif
	</div>


@else
	<div class="form-group">
	    <input type="radio" name="order_status" data-labelauty="تراجع" value="backward" class="labelauty" required>
	    <input type="radio" name="order_status" data-labelauty="{{ $order->is_prepared() ? 'تم التسليم' : 'الانتقال للمرحلة التالية' }}" value="forward" class="labelauty" {{ !$order->is_delivered() ? '' : 'disabled' }}>
	</div>
@endif