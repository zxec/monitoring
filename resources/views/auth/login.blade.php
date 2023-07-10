@extends('layouts.app')

@section('content')
<div class="container mt-5 py-5">
    <div class="row justify-content-center pt-5 mt-5">
        <div class="col-xl-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3 justify-content-center">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Логин') }}</label> --}}

                            <div class="col-xl-8">
                                <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus placeholder="{{ __('auth.login') }}">

                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Пароль') }}</label> --}}

                            <div class="col-xl-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" autofocus placeholder="{{ __('auth.password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Сервер') }}</label> --}}

                            {{-- <div class="col-xl-8">
                                <input id="server" type="text" class="form-control @error('server') is-invalid @enderror" name="server" value="{{ old('server') }}" autocomplete="server" autofocus placeholder="{{ __('Сервер') }}">

                                @error('server')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                        </div>

                        {{--
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row mb-3 justify-content-center">
                            <div class="col-xl-8">
                                <button type="submit"  class="btn btn-success w-100">
                                    {{ __('auth.login_as_performer') }}
                                </button>
                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                        <div class="row mb-0 justify-content-center">
                            <div class="col-xl-8">
                                <button type="submit" name="admin" class="btn btn-primary w-100">
                                    {{ __('auth.login_as_admin') }}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
