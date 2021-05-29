@extends('auth.layouts.auth')

@section('title', 'تسجيل الدخول')

@section('page-content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        @if (session('registered'))
            <div class="form-group row">
                <div class="col">
                    <div class="alert alert-warning">
                        <div class="media">
                            <div class="media-head pl-3 pt-2">
                                <i class="fa fa-check-circle" style="font-size: 30px; opacity: .6;"></i>
                            </div>
                            <div class="media-body">
                                لقد قمت بالتسجيل بنجاح من فضلك تفقد حسابك على واتساب, <br>
                                لقد قمنا بإرسال رسالة تحتوي على كلمة مرور مؤقتة ستتمكن من خلالها الدخول لحسابك.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('reset'))
            <div class="form-group row">
                <div class="col">
                    <div class="alert alert-warning">
                        <div class="media">
                            <div class="media-head pl-3 pt-2">
                                <i class="fa fa-info-circle" style="font-size: 30px; opacity: .6;"></i>
                            </div>
                            <div class="media-body">
                                من فضلك قم بتفقد حسابك على واتساب, <br>
                                لقد قمنا بإرسال رسالة تحتوي على كلمة مرور مؤقتة ستتمكن من خلالها الدخول لحسابك.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="form-group row">
            <label for="phoneoremail" class="col-md-4 col-form-label text-md-right">الهاتف أو البريد الالكتروني</label>

            <div class="col-md-8">
                <input id="phoneoremail" type="tel" class="form-control @error('phoneoremail') is-invalid @enderror" name="phoneoremail" value="{{ old('phoneoremail') }}" required autocomplete="phoneoremail" autofocus dir="ltr">

                @error('phoneoremail')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-8">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" dir="ltr">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <div class="form-check float-left">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label py-3" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="submit-btn">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>

        <hr class="p-3">

        <div class="col-md-12 text-center">
            ليس لديك حساب ؟
            <a href="{{ route('register') }}">تسجيل حساب جديد</a>
        </div>
    </form>
@endsection
