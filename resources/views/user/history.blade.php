@extends('layouts.app')

@section('title', __('pligg.user.history.title'))

@section('content')
    @include('user.navigation')

    @if(isset($user_page))
        {!! $user_page !!}
        @if($user_page === '')
            <div class="jumbotron" style="padding:15px 25px;">
                <p style="padding:0;margin:0;font-size:1.1em;">
                    {{ __('pligg.user.profile.no_content') }}
                </p>
            </div>
        @endif
    @endif

    @if(isset($user_pagination) && $user_page !== '')
        @hook('tpl_pligg_pagination_start')
        {!! $user_pagination !!}
        @hook('tpl_pligg_pagination_end')
    @endif

    @hook('tpl_pligg_profile_end')
@endsection
