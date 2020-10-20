<?php $user = isset($user) && $user ? $user : Auth::user(); ?>
<div class="row mt-4" dir="rtl">
    <div class="col-sm-12 col-lg-4 col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center ">
                
                @if (request()->route()->getPrefix() != 'admin')
                    <a href="#" data-toggle="modal" data-target="#balance-details-modal" style="position: absolute; top: 10px; left: 15px; font-size: 15px; opacity: 0.7;"><i class="fa fa-question"></i></a>
                @endif

            	@if(!isset($noicon))
                	<h3 class="text-success pb-2 pt-3" style="font-size: 30px;"><i class="fa fa-money-bill-alt"></i></h3>
                @endif
                <div class="text mb-2"> الرصيد المتاح </div>
                <h3 class="mb-4"><span class="payout-balance">{{ $user->payout_balance() }}</span> <small>{{ currency()->symbol }}</small></h3>
                <p>الرصيد المتاح للسحب.</p>

                @if (auth()->user()->id == $user->id && request()->route()->getPrefix() != 'admin')
				    <a href="#" data-toggle="modal" data-target="#make-transaction-modal">سحب الرصيد</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body text-center ">
            	@if(!isset($noicon))
                	<h3 class="text-primary pb-2 pt-3" style="font-size: 30px;"><i class="fa fa-dollar-sign"></i></h3>
                @endif
                <div class="text mb-2"> الرصيد المعلق </div>
                <h3 class="mb-4">{{ $user->reserved_balance() }} <small>{{ currency()->symbol }}</small></h3>
                <p>رصيد معلق لفترة مؤقتة.</p>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 col-md-12 mb-3">
        <div class="card h-100">
            <div class="card-body text-center ">
            	@if(!isset($noicon))
                	<h3 class="text-danger pb-2 pt-3" style="font-size: 30px;"><i class="fa fa-heart"></i></h3>
                @endif
                <div class="text mb-2"> إجمالي المصروفات </div>
                <h3 class="mb-4"><span class="expensed-balance">{{ $user->expensed_balance() }}</span> <small>{{ currency()->symbol }}</small></h3>
                <p>إجمالي المبلغ المستهلك لترقية الإعلانات للعضوية المميزة.</p>
            </div>
        </div>
    </div>
</div>

@if (request()->route()->getPrefix() != 'admin')
    <div class="alert alert-info">
        يمكنك شحن رصيد محفظتك باستخدام البطاقة الائتمانية
        <a href="/balance" class="btn btn-sm btn-info float-left">شحن الرصيد</a>
    </div>
@endif
