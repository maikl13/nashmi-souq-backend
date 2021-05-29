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
            <label for="phoneoremail" class="col-md-4 col-form-label text-md-right">الهاتف أو البريد الالكتروني</label>

            <div class="col-md-8">
                <input id="phoneoremail" type="phoneoremail" class="form-control @error('phoneoremail') is-invalid @enderror" name="phoneoremail" value="{{ old('phoneoremail') }}" required autocomplete="phoneoremail" autofocus>

                @error('phoneoremail')
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
