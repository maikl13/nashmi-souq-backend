<div class="card h-100">
	<div class="card-header text-right">
		<h4> بيانات المشتري </h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered text-right">
				<tbody>
					<tr>
						<td> الحساب </td>
						<td class="text-right"><a href="{{ config('app.url') }}/users/{{ $order->user->id }}/">{{ $order->user->name }}</a></td>
					</tr>
					<tr>
						<td>الاسم</td>
						<td class="text-right">{{ $order->buyer_name }}</td>
					</tr>
					<tr>
						<td>العنوان</td>
						<td class="text-right">مصر - {{ $order->state->name }}</td>
					</tr>
					<tr>
						<td>العنوان تفصيلي</td>
						<td class="text-right">{{ $order->address }}</td>
					</tr>
					<tr>
						<td>الهاتف</td>
						<td class="text-right">{{ $order->phone }}</td>
					</tr>
					<tr>
						<td>وسيلة الدفع</td>
						<td class="text-right">{{ $order->get_payment_method() }}</td>
					</tr>
					{{-- <tr>
						<td>طريقة الاستلام</td>
						<td class="text-right">{{ $order->shipping_method() }}</td>
					</tr> --}}
				</tbody>
			</table>
		</div> 
	</div>
</div>