@extends('auth.layouts.auth')

@section('title', 'تسجيل حساب جديد')

@section('page-head')
    <link rel="stylesheet" href="/assets/plugins/ccpicker/css/jquery.ccpicker.css">
    <style>
        .cc-picker {
            min-width: 85px;
            padding: 8px 23px 8px 7px;
            background: #e0e0e0;
        }
        .cc-picker-code-select-enabled::after {
            top: 19px;
            right: 10px;
        }
        .cc-picker-code {width: 27px;}
        #phone {
            background-color: #f6f6f6;
            border-radius: 0;
            font-size: 1rem;
            padding: 0.3125rem 0.625rem;
            box-shadow: 0rem 0.0625rem 0rem 0rem rgba(216, 216, 216, 0.75);
            border: none;
        }
        .cc-picker-code-list,
        .cc-picker-code-filter {
            direction: ltr;
            text-align: left;
            margin-left: 0;
        }
        .cc-picker-code-filter {
            padding: 15px;
            width: 290px;
        }
        .cc-picker-code-list {
            margin-top: 10px;
            padding-left: 10px;
        }
    </style>
@endsection

@section('page-content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>

            <div class="col-md-9">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-9">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-9">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <div class="col-md-9">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div> --}}


        <div class="form-group row">
            <label for="phone" class="col-md-12 col-form-label text-md-right">{{ __('Phone') }} :</label>

            <div class="col-md-12">
                <div class="d-flex" dir="ltr">
                    <input id="phone" type="tel" class="text-left w-100 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="رقم الهاتف">
                </div>

                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="submit-btn">
                    {{ __('Register') }}
                </button>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col">
                <div class="alert alert-warning mb-0">
                    <div class="media">
                        <div class="media-head pl-3 pt-2">
                            <i class="fa fa-info-circle" style="font-size: 30px; opacity: .6;"></i>
                        </div>
                        <div class="media-body">
                            بمجرد التسجيل سيتم إرسال رسالة على حساب الواتساب الخاص بك تحتوي على كلمة سر مؤقتة ستتمكن من خلالها الولوج لحسابك, و بعدها ستتمكن من تغيير كلمة السر إن رغبت في ذلك.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="p-3">

        <div class="col-md-12 text-center">
            لديك حساب بالفعل ؟
            <a href="{{ route('login') }}">تسجيل الدخول</a>
        </div>
    </form>
@endsection

@section('page-scripts')
    <script src="/assets/plugins/ccpicker/js/jquery.ccpicker.min.js" type="text/javascript"></script>
    <script>
        $("#phone").CcPicker({
            "dataUrl": "/assets/plugins/ccpicker/data.json",
            "countryCode": "{{ strtolower(location()->code) }}"
        });
    </script>
@endsection