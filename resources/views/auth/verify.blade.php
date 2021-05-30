@extends('auth.layouts.auth')

@section('title', __('Verify Your Email Address'))

@section('card-title')
    <div class="text-center text-danger" style="opacity: .7;">
        <i class="fa fa-exclamation-circle fa-3x m-2"></i>
    </div>
@endsection

@section('hero-area')
    @if (session('resent'))
        <div class="alert alert-success py-4 m-0 rounded-0 text-center" role="alert">
            <div class="container text-center">
                <div class="fa fa-check-circle fa-2x text-success"></div> <br>
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        </div>
    @endif
@endsection

@section('page-content')

    <div class="text-center">        
        <p>
            لم تقم بتأكيد بريدك الالكتروني
            {{ auth()->user()->email ?? '' }}. 
            <br>
            قمنا بإرسال رابط تحقق لعنوان بريدك الالكتروني
            <br>
            قبل المتابعة، يرجى تأكيد بريدك الإلكتروني عن طريق رابط التحقق.
        </p>

        <hr class="p-3">

        <div class="col-md-12 text-center">
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
@endsection
