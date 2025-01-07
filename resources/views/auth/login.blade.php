@extends('layouts.app')

@section('title', __('Login'))

@section('content')
<div class="row">
    @hook('tpl_login_top')
    <div class="col-md-4 login-left">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <button class="close" data-dismiss="alert">&times;</button>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf
            <h2>{{ __('pligg.login.login') }}</h2>
            <p>{{ __('pligg.login.have_account') }}</p>

            <div class="form-group">
                <label for="login"><strong>{{ __('pligg.login.username_email') }}</strong></label>
                <input type="text" class="form-control @error('login') is-invalid @enderror"
                       id="login" name="login" value="{{ old('login') }}" 
                       required autofocus tabindex="1">
            </div>

            <div class="form-group">
                <label for="password"><strong>{{ __('pligg.login.password') }}</strong></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required tabindex="2">
            </div>

            <div class="login-submit">
                <button type="submit" class="btn btn-primary" tabindex="4">
                    {{ __('pligg.login.login_button') }}
                </button>
            </div>

            <div class="login-remember">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} tabindex="3">
                    {{ __('pligg.login.remember') }}
                </label>
            </div>

            @if(request()->has('return'))
                <input type="hidden" name="return" value="{{ request('return') }}">
            @endif
        </form>
    </div>

    <div class="col-md-4 login-middle">
        <h2>{{ __('pligg.login.forgotten_password') }}</h2>
        <p>{{ __('pligg.login.email_change_pass') }}</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="recovery-email"><strong>{{ __('pligg.login.email') }}</strong></label>
                <input type="email" class="form-control" id="recovery-email" 
                       name="email" required tabindex="5">
            </div>
            <button type="submit" class="btn btn-primary" tabindex="6">
                {{ __('pligg.login.submit') }}
            </button>
            @if(request()->has('return'))
                <input type="hidden" name="return" value="{{ request('return') }}">
            @endif
        </form>
    </div>

    <div class="col-md-4 login-right">
        <h2>{{ __('pligg.login.new_users') }}</h2>
        <p>
            {{ __('pligg.login.new_users_a') }}
            <a href="{{ route('register') }}" class="btn btn-success btn-xs" tabindex="7">
                {{ __('pligg.login.new_users_b') }}
            </a>
            {{ __('pligg.login.new_users_c') }}
        </p>

        @if(config('pligg.social_login.enabled', false))
            <hr>
            <div class="social-auth-links text-center">
                @if(config('pligg.social_login.facebook', false))
                    <a href="{{ route('login.facebook') }}" 
                       class="btn btn-block btn-social btn-facebook" tabindex="8">
                        <i class="fa fa-facebook"></i> {{ __('pligg.login.facebook') }}
                    </a>
                @endif

                @if(config('pligg.social_login.twitter', false))
                    <a href="{{ route('login.twitter') }}" 
                       class="btn btn-block btn-social btn-twitter" tabindex="9">
                        <i class="fa fa-twitter"></i> {{ __('pligg.login.twitter') }}
                    </a>
                @endif
            </div>
        @endif
    </div>
    @hook('tpl_login_bottom')
</div>
@endsection
