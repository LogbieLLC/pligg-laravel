@extends('layouts.app')

@section('title', __('pligg.user.profile.title', ['username' => $user_username]))

@section('content')
    @include('user.navigation')

    @if($user_view === 'profile')
        <div id="profile_container" style="position: relative;">
            <div class="row">
                @hook('tpl_pligg_profile_info_start')
                @hook('tpl_pligg_profile_info_middle')
                
                <div id="stats" class="col-md-6">
                    <table class="table table-bordered table-striped vertical-align">
                        <thead class="table_title">
                            <tr>
                                <th colspan="2">{{ __('pligg.user.profile.user_stats') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($user_karma > 0.00)
                                <tr>
                                    <td><strong>{{ __('pligg.rank') }}:</strong></td>
                                    <td>{{ $user_rank }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('pligg.user.profile.karma_points') }}:</strong></td>
                                    <td>{{ number_format($user_karma, 0) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>{{ __('pligg.user.profile.joined') }}:</strong></td>
                                <td width="120px">{{ date('F d, Y', strtotime($user_joined)) }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('pligg.user.profile.total_links') }}:</strong></td>
                                <td>{{ $user_total_links }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('pligg.user.profile.published_links') }}:</strong></td>
                                <td>{{ $user_published_links }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('pligg.user.profile.total_comments') }}:</strong></td>
                                <td>{{ $user_total_comments }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('pligg.user.profile.total_votes') }}:</strong></td>
                                <td>{{ $user_total_votes }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if(config('pligg.enable_group'))
                    <div id="groups" class="col-md-6">
                        <table class="table table-bordered table-striped vertical-align">
                            <thead class="table_title">
                                <tr>
                                    <th>{{ __('pligg.admin.group_name') }}</th>
                                    @if($group_display)<th style="width:60px;text-align:center;">{{ __('pligg.group.member') }}</th>@endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$group_display)
                                    <tr>
                                        <td colspan="2">{{ __('pligg.profile.no_membership') }}</td>
                                    </tr>
                                @else
                                    {!! $group_display !!}
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif

                @if(config('pligg.allow_friends'))
                    <div id="following" class="col-md-6">
                        <table class="table table-bordered table-striped vertical-align">
                            <thead class="table_title">
                                <tr>
                                    <th>{{ __('pligg.user.profile.friends') }}</th>
                                    @hook('tpl_pligg_profile_friend_th')
                                    @if(Module::isEnabled('simple_messaging') && $user_logged_in && $following)
                                        <th>{{ __('pligg.user.profile.message') }}</th>
                                    @endif
                                    @if($user_authenticated)
                                        <th>{{ __('pligg.user.profile.add_friend') }} / {{ __('pligg.user.profile.remove_friend') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if($following)
                                    @foreach($following as $friend)
                                        <tr>
                                            <td>
                                                <a href="{{ route('user.profile', $friend->user_login) }}">
                                                    <img src="{{ get_avatar('small', $friend->user_avatar_source, $friend->user_login, $friend->user_email) }}" 
                                                         style="text-decoration:none;border:0;"/>
                                                </a>
                                                <a href="{{ route('user.profile', $friend->user_login) }}">{{ $friend->user_login }}</a>
                                            </td>
                                            @if($user_authenticated && $friend->is_mutual === 'mutual')
                                                <td style="text-align:center">
                                                    <a href="{{ route('message.compose', ['to' => $friend->user_login]) }}" 
                                                       class="btn btn-default">
                                                        <i class="fa fa-envelope"></i>
                                                    </a>
                                                </td>
                                            @elseif($user_authenticated)
                                                <td>&nbsp;</td>
                                            @endif
                                            @hook('tpl_pligg_profile_friend_td')
                                            @if($user_authenticated && ($friend->is_mutual === 'mutual' || $friend->is_mutual === 'following'))
                                                <td>
                                                    <a class="btn btn-danger" 
                                                       href="{{ route('user.friend.remove', $friend->user_login) }}">
                                                        {{ __('pligg.user.profile.remove_friend') }}
                                                    </a>
                                                </td>
                                            @elseif(!$user_authenticated)
                                            @else
                                                <td>
                                                    <a class="btn btn-success" 
                                                       href="{{ route('user.friend.add', $friend->user_login) }}">
                                                        {{ __('pligg.user.profile.add_friend') }}
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">
                                            {{ ucfirst($user_username) }} {{ __('pligg.user.profile.no_friends') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif

                @hook('tpl_pligg_profile_info_end')
                <div style="clear:both;"></div>
                @hook('tpl_pligg_profile_tab_insert')
            </div>
        </div>
    @endif

    @if(isset($user_page))
        {!! $user_page !!}
        @if($user_page === '')
            <div class="jumbotron" style="padding:15px 25px;">
                <p style="padding:0;margin:0;font-size:1.1em;">{{ __('pligg.user.profile.no_content') }}</p>
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
