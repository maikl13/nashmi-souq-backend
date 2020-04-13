<?php $user = isset($user) && $user ? $user : Auth::user(); ?>
<div class="tab-pane fade" id="payment" role="tabpanel">
    <div class="myaccount-payment light-shadow-bg">
        <div class="light-box-content">
            @include('main.users.partials.balance')
            @include('main.users.partials.transactions-table')
        </div>
    </div>
</div>