<div class="card border-0">
	<div class="card-header text-right text-white rounded-0" style="background-color: #f85c70;">
		<h4 class="d-inline float-right text-white m-0">حالة الطلب - <small class="order-status">{{ $order->status() }}</small></h4>
        <div class="float-left">
            @if(!$order->is_cancelled_by_buyer())
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#change-status-modal" >
                    <i class="fa fa-gear" ></i> تعديل حالة الطلب 
                </button>
            @endif

            <a class="btn btn-danger btn-sm" data-toggle="collapse" href="#order-status-log" role="button" aria-expanded="false" aria-controls="order-status-log"> سجل تغييرات حالة الطلب </a>
        </div>
	</div>
	<div class="card-body py-0">
		<div class="table-responsive ">
            <div class="collapse mt-3" id="order-status-log">
                <table class="table table-bordered cart-items text-center" dir="rtl">
                    <thead>
                        <tr>
                            <th class="py-4"> قام </th>
                            <th class="py-4"> بتغيير حالة الطلب لـ </th>
                            <th class="py-4"> و ذلك </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $order->order_status_updates()->latest()->get() as $order_status_update )
                            <tr>
                                <td class="py-1">{{ $order_status_update->user->name }}</td>
                                <td class="py-1">{{ $order_status_update->status() }}</td>
                                <td class="py-1" title="{{ $order_status_update->created_at }}">{{ $order_status_update->created_at->diffForHumans() }}</td>
                            </tr>
                            @if ($order_status_update->note)
                                <tr><td class="py-1" colspan="3">{!! nl2br($order_status_update->note) !!}</td></tr>
                            @endif
                        @endforeach
                        <tr>
                            <td class="py-1">{{ $order->user->name }}</td>
                            <td class="py-1">طلب جديد</td>
                            <td class="py-1" title="{{ $order->created_at }}"> {{ $order->created_at->diffForHumans() }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div> 
	</div>
</div>