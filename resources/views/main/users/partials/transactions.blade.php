<div class="tab-pane fade" id="payment" role="tabpanel">
    <div class="myaccount-payment light-shadow-bg">
        <div class="light-box-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>كود العملية</th>
                            <th>نوع العملية</th>
                            <th>القيمة</th>
                            <th>وسيلة الدفع</th>
                            <th>الحالة</th>
                            <th>تاريخ التنفيذ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->uid }}</td>
                                <td>{{ $transaction->type() }}</td>
                                <td>
                                    <div class="price-amount">
                                        {{ $transaction->amount }}
                                        <span class="currency-symbol">ج م</span>
                                    </div>
                                </td>
                                <td>{{ $transaction->payment_method() }}</td>
                                <td>{{ $transaction->status() }}</td>
                                <td>{{ $transaction->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-5">لا يوجد أي معاملات مالية حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>