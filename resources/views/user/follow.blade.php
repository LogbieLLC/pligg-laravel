@extends('layouts.app')

@section('title')
    @if($user_view === 'following')
        {{ __('pligg.user.profile.following_title', ['username' => ucfirst($user_username)]) }}
    @elseif($user_view === 'followers')
        {{ __('pligg.user.profile.followers_title', ['username' => ucfirst($user_username)]) }}
    @else
        {{ __('pligg.user.profile.friends_title', ['username' => ucfirst($user_username)]) }}
    @endif
@endsection

@section('content')
    @include('user.navigation')

    @if($user_view === 'removefriend')
        <div class="alert alert-warning">
            <button class="close" data-dismiss="alert">&times;</button>
            {{ __('pligg.user.profile.friend_removed') }}
        </div>
    @endif

    @if($user_view === 'addfriend')
        <div class="alert alert-success">
            <button class="close" data-dismiss="alert">&times;</button>
            {{ __('pligg.user.profile.friend_added') }}
        </div>
    @endif

    @if($user_view === 'following')
        <legend>
            {{ __('pligg.user.profile.people') }} 
            {{ ucfirst($user_username) }} 
            {{ __('pligg.user.profile.is_following') }}
        </legend>
        @if($following)
            <table class="table table-bordered table-condensed table-striped vertical-align">
                <thead>
                    <tr>
                        <th>{{ __('pligg.user.profile.username') }}</th>
                        @if($user_authenticated)
                            <th>{{ __('pligg.user.profile.add_friend') }} / {{ __('pligg.user.profile.remove_friend') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($following as $friend)
                        <tr>
                            <td>
                                <img src="{{ get_avatar('small', $friend->user_avatar_source, $friend->user_login, $friend->user_email) }}" 
                                     align="absmiddle" /> 
                                <a href="{{ route('user.profile', $friend->user_login) }}">{{ $friend->user_login }}</a>
                            </td>
                            @if($user_authenticated && $friend->following > 0)
                                <td>
                                    <a href="{{ route('user.friend.remove', $friend->user_login) }}" 
                                       class="btn btn-danger">
                                        {{ __('pligg.user.profile.remove_friend') }}
                                    </a>
                                </td>
                            @elseif($user_authenticated)
                                <td>
                                    <a href="{{ route('user.friend.add', $friend->user_login) }}" 
                                       class="btn btn-success">
                                        {{ __('pligg.user.profile.add_friend') }}
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h3 class="text-center">
                {{ ucfirst($user_username) }} {{ __('pligg.user.profile.no_friends') }}
            </h3>
        @endif
    @endif

    @if($user_view === 'followers')
        <legend>
            {{ __('pligg.user.profile.viewing_friends_2a') }} {{ ucfirst($user_username) }}
        </legend>
        @if($follower)
            <table class="table table-bordered table-condensed table-striped vertical-align">
                <thead>
                    <tr>
                        <th>{{ __('pligg.user.profile.username') }}</th>
                        @if(Module::isEnabled('simple_messaging'))
                            <th>{{ __('pligg.user.profile.message') }}</th>
                        @endif
                        @if($user_authenticated)
                            <th>{{ __('pligg.user.profile.add_friend') }} / {{ __('pligg.user.profile.remove_friend') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($follower as $friend)
                        <tr>
                            <td>
                                <img src="{{ get_avatar('small', $friend->user_avatar_source, $friend->user_login, $friend->user_email) }}" 
                                     align="absmiddle" /> 
                                <a href="{{ route('user.profile', $friend->user_login) }}">{{ $friend->user_login }}</a>
                            </td>
                            @if(Module::isEnabled('simple_messaging') && $friend->is_friend)
                                <td>
                                    <a href="{{ route('message.compose', ['to' => $friend->user_login]) }}" 
                                       class="btn btn-sm btn-default">
                                        <i class="fa fa-envelope"></i>
                                    </a>
                                </td>
                            @else
                                <td></td>
                            @endif
                            @if($user_authenticated)
                                @if($friend->is_friend > 0)
                                    <td>
                                        <a class="btn btn-sm btn-danger" 
                                           href="{{ route('user.friend.remove', $friend->user_login) }}">
                                            {{ __('pligg.user.profile.remove_friend') }}
                                        </a>
                                    </td>
                                @else
                                    <td>
                                        <a class="btn btn-sm btn-success" 
                                           href="{{ route('user.friend.add', $friend->user_login) }}">
                                            {{ __('pligg.user.profile.add_friend') }}
                                        </a>
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h4>
                {{ __('pligg.user.profile.no_friends_2') }} {{ ucfirst($user_username) }}
            </h4>
        @endif
    @endif

    @if(isset($user_page))
        {!! $user_page !!}
    @endif

    @if(isset($user_pagination))
        @hook('tpl_pligg_pagination_start')
        {!! $user_pagination !!}
        @hook('tpl_pligg_pagination_end')
    @endif

    @hook('tpl_pligg_profile_end')
@endsection
