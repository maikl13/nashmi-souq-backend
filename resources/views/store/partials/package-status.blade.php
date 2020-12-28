<?php
    $done = '<i class="fa fa-check"></i>';
    $endpoint = '<i class="fa fa-times"></i>';
?>
<div class="stepwizard">
    <div class="stepwizard-row">
        <div class="stepwizard-step">
            <button type="button" class="btn btn-primary btn-circle" disabled="disabled">{!! $done !!}</button>
            <p>تم الطلب</p>
        </div>
        <div class="stepwizard-step">
            <?php
                if( $package->is_cancelled() ){
                    $status_before_cancelling = $package->package_status_updates()->latest()->offset(1)->first();
                    $last_status = $status_before_cancelling ? $status_before_cancelling->status : App\Models\Package::STATUS_PENDING;
                }
            ?>
            @if( $package->is_approved() || $package->is_deliverable() || $package->is_prepared() || ($package->is_cancelled() && $last_status != App\Models\Package::STATUS_PENDING) || $package->is_delivered() )
                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">{!! $done !!}</button>
            @elseif( $package->is_rejected() )
                <button type="button" class="btn btn-danger btn-circle" disabled="disabled">{!! $endpoint !!}</button>
            @elseif( ($package->is_cancelled() && $last_status == App\Models\Package::STATUS_PENDING) )
                <button type="button" class="btn btn-danger btn-circle" disabled="disabled">{!! $endpoint !!}</button>
            @elseif( $package->is_pending() )
                <button type="button" class="btn btn-default btn-circle" disabled="disabled">2</button>
            @endif
            <p>تم قبول <br> الطلب</p>
        </div>
        <div class="stepwizard-step">
            @if( $package->is_deliverable() || $package->is_prepared() || $package->is_delivered() || ($package->is_cancelled() && ($last_status != App\Models\Package::STATUS_APPROVED) && ($last_status != App\Models\Package::STATUS_PENDING) ))
                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">{!! $done !!}</button>
            @elseif( $package->is_deliverable() )
                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
            @elseif( ($package->is_cancelled() && $last_status == App\Models\Package::STATUS_APPROVED) )
                <button type="button" class="btn btn-danger btn-circle" disabled="disabled">{!! $endpoint !!}</button>
            @else
                <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
            @endif
            <p>مرحلة <br> التجهيز</p>
        </div>
        <div class="stepwizard-step">
            @if( $package->is_prepared() || $package->is_delivered() )
                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">{!! $done !!}</button>
            @elseif( ($package->is_cancelled() && $last_status == App\Models\Package::STATUS_DELIVERABLE) )
                <button type="button" class="btn btn-danger btn-circle" disabled="disabled">{!! $endpoint !!}</button>
            @else
                <button type="button" class="btn btn-default btn-circle" disabled="disabled">4</button>
            @endif
            <p>مرحلة <br> التسليم</p>
        </div> 
        <div class="stepwizard-step">
            @if( $package->is_delivered() )
                <button type="button" class="btn btn-primary btn-circle" disabled="disabled">{!! $done !!}</button>
            @else
                <button type="button" class="btn btn-default btn-circle" disabled="disabled">5</button>
            @endif
            <p>تم التسليم</p>
        </div> 
    </div>
</div>

<style type="text/css" media="screen">
    @media (max-width: 319px) {
        .stepwizard-step:nth-child(3){
            display: none;
        }
    }
    @media (max-width: 439px) {
        .stepwizard-step:last-child{
            display: none;
        }
    }

    .stepwizard-step p {
        margin-top: 10px;    
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;     
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }
    .stepwizard-step button.btn-default[disabled] {
        background-color: buttonface;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #eee;
        z-order: 0;
        
    }

    .stepwizard-step {    
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
      width: 30px;
      height: 30px;
      text-align: center;
      padding: 6px 0;
      font-size: 12px;
      line-height: 1.428571429;
      border-radius: 15px;
    }

    .btn-circle.btn-primary {
      background-color: #f85c70 !important;
      border-color: #f85c70 !important;
    }
</style>