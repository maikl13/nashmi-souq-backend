<?php $user = isset($user) && $user ? $user : Auth::user(); ?>
<div class="row mt-4" dir="rtl">
    <div class="col-sm-12 col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body text-center ">
            	@if(!isset($noicon))
                	<h3 class="text-primary pb-2 pt-3" style="font-size: 30px;"><i class="fa fa-dollar-sign"></i></h3>
                @endif
                <div class="text mb-2"> الرصيد الكلى </div>
                <h3 class="mb-4">{{ $user->total_balance() }} <small>$</small></h3>
                <p>إجمالى المبلغ المودع في حسابك منذ بداية فتح الحساب حتى الآن.</p>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body text-center ">
            	@if(!isset($noicon))
                	<h3 class="text-success pb-2 pt-3" style="font-size: 30px;"><i class="fa fa-money-bill-alt"></i></h3>
                @endif
                <div class="text mb-2"> الرصيد الحالي </div>
                <h3 class="mb-4">{{ $user->current_balance() }} <small>$</small></h3>
                <p>الرصيد الحالي و يمكنك بواسطته ترقية الإعلانات لإعلان مميز.</p>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4 col-md-12 mb-3">
        <div class="card">
            <div class="card-body text-center ">
            	@if(!isset($noicon))
                	<h3 class="text-danger pb-2 pt-3" style="font-size: 30px;"><i class="fa fa-heart"></i></h3>
                @endif
                <div class="text mb-2"> إجمالي المصروفات </div>
                <h3 class="mb-4">{{ $user->expensed_balance() }} <small>$</small></h3>
                <p>إجمالي المبلغ المستهلك لترقية الإعلانات للعضوية المميزة.</p>
            </div>
        </div>
    </div>
</div>