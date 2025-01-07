@extends('layouts.app')

@section('title', __('Register'))

@section('content')
<div class="row register-wrapper">
    <div class="col-md-4 register-left">
        @hook('tpl_pligg_register_start')

        @if ($errors->any())
            <div class="alert alert-danger">
                <button class="close" data-dismiss="alert">&times;</button>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" class="form-horizontal" method="post" id="register-form">
            @csrf

            <div class="control-group">
                <label class="control-label">{{ __('pligg.register.username') }}</label>
                <div class="controls">
                    @if($errors->has('username'))
                        @foreach($errors->get('username') as $error)
                            <div class="alert alert-danger">
                                <button class="close" data-dismiss="alert">&times;</button>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <input autofocus="autofocus" type="text" 
                           class="form-control reg_username @error('username') is-invalid @enderror" 
                           id="reg_username" name="username" 
                           value="{{ old('username') }}" 
                           tabindex="10" maxlength="32"/>
                    <span class="reg_usernamecheckitvalue"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">{{ __('pligg.register.email') }}</label>
                <div class="controls">
                    @if($errors->has('email'))
                        @foreach($errors->get('email') as $error)
                            <div class="alert alert-danger">
                                <button class="close" data-dismiss="alert">&times;</button>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <input type="text" 
                           class="form-control reg_email @error('email') is-invalid @enderror" 
                           id="reg_email" name="email" 
                           value="{{ old('email') }}" 
                           tabindex="12" maxlength="128"/>
                    <span class="reg_emailcheckitvalue"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">{{ __('pligg.register.password') }}</label>
                <div class="controls">
                    @if($errors->has('password'))
                        @foreach($errors->get('password') as $error)
                            <div class="alert alert-danger">
                                <button class="close" data-dismiss="alert">&times;</button>
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="reg_password" name="password" 
                           tabindex="14"/>
                    <p class="help-inline">{{ __('pligg.register.five_char') }}</p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">{{ __('pligg.register.verify_password') }}</label>
                <div class="controls">
                    <input type="password" class="form-control" 
                           id="reg_verify" name="password_confirmation" 
                           tabindex="15"/>
                </div>
            </div>

            @if(config('pligg.registration.terms_required', true))
                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox">
                            <input type="checkbox" name="terms" required tabindex="15">
                            {!! __('pligg.register.terms_agreement', [
                                'terms' => '<a href="'.route('terms').'">'.__('Terms of Service').'</a>',
                                'privacy' => '<a href="'.route('privacy').'">'.__('Privacy Policy').'</a>'
                            ]) !!}
                        </label>
                    </div>
                </div>
            @endif

            @hook('register_step_1_extra')

            <div class="form-actions">
                <button type="submit" name="submit" 
                        class="btn btn-primary reg_submit" 
                        tabindex="16">
                    {{ __('pligg.register.create_user') }}
                </button>
                <input type="hidden" name="regfrom" value="full" />
            </div>
        </form>
    </div>

    <div class="col-md-8 register-right">
        <h2>{{ __('pligg.register.description_title') }}</h2>
        <p>{!! __('pligg.register.description_paragraph') !!}</p>
        <ul>
            {!! __('pligg.register.description_points') !!}
        </ul>
    </div>

    @hook('tpl_pligg_register_end')
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Username availability check
    let usernameTimer;
    $('#reg_username').on('keyup', function() {
        clearTimeout(usernameTimer);
        usernameTimer = setTimeout(function() {
            $.get('{{ route("check.username") }}', {
                username: $('#reg_username').val()
            }).done(function(response) {
                $('.reg_usernamecheckitvalue').html(response.available ? 
                    '<span class="text-success">{{ __("pligg.register.username_available") }}</span>' : 
                    '<span class="text-danger">{{ __("pligg.register.username_taken") }}</span>');
            });
        }, 500);
    });

    // Email availability check
    let emailTimer;
    $('#reg_email').on('keyup', function() {
        clearTimeout(emailTimer);
        emailTimer = setTimeout(function() {
            $.get('{{ route("check.email") }}', {
                email: $('#reg_email').val()
            }).done(function(response) {
                $('.reg_emailcheckitvalue').html(response.available ? 
                    '<span class="text-success">{{ __("pligg.register.email_available") }}</span>' : 
                    '<span class="text-danger">{{ __("pligg.register.email_taken") }}</span>');
            });
        }, 500);
    });
});
</script>
@endpush
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Username availability check
    let usernameTimer;
    $('#username').on('keyup', function() {
        clearTimeout(usernameTimer);
        usernameTimer = setTimeout(function() {
            $.get('{{ route("check.username") }}', {
                username: $('#username').val()
            }).done(function(response) {
                $('.username-check-result').html(response.available ? 
                    '<span class="text-success">{{ __("Username available") }}</span>' : 
                    '<span class="text-danger">{{ __("Username taken") }}</span>');
            });
        }, 500);
    });

    // Email availability check
    let emailTimer;
    $('#email').on('keyup', function() {
        clearTimeout(emailTimer);
        emailTimer = setTimeout(function() {
            $.get('{{ route("check.email") }}', {
                email: $('#email').val()
            }).done(function(response) {
                $('.email-check-result').html(response.available ? 
                    '<span class="text-success">{{ __("Email available") }}</span>' : 
                    '<span class="text-danger">{{ __("Email already registered") }}</span>');
            });
        }, 500);
    });
});
</script>
@endpush
