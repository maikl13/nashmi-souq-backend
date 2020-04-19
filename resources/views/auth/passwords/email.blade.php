@extends('auth.layouts.auth')

@section('title', __('Reset Password'))

@section('page-content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group row">
            <label for="phone" class="col-md-3 col-form-label text-md-right">{{ __('Phone') }}</label>

            <div class="col-md-9">
                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
                <button type="submit" class="submit-btn">
                    أرسل كلمة مرور مؤقتة
                </button>
            </div>
        </div>
    </form>
@endsection
