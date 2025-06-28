@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100" style="background: #f8fafc;">
    <div class="col-md-5 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3" style="background: #fff;">
            <div class="card-body p-4">
                <h3 class="mb-4 text-center fw-semibold" style="letter-spacing:1px;">{{ __('Login') }}</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label small text-muted">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control border-0 border-bottom rounded-0 shadow-none @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="background:transparent;">
                        @error('email')
                            <div class="invalid-feedback d-block small">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small text-muted">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control border-0 border-bottom rounded-0 shadow-none @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" style="background:transparent;">
                        @error('password')
                            <div class="invalid-feedback d-block small">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark rounded-pill py-2">
                            {{ __('Login') }}
                        </button>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="small text-decoration-none text-muted" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
