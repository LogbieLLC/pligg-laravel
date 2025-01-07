@extends('layouts.app')

@section('title', __('pligg.user.settings.title'))

@section('content')
    @include('user.navigation')

    @if($savemsg)
        <div class="alert alert-warning fade in">
            <a data-dismiss="alert" class="close">&times;</a>
            {{ $savemsg }}
        </div>
    @endif

    @hook('tpl_pligg_profile_info_start')

    <form action="{{ route('user.settings.update') }}" method="post" id="settings-form" role="form">
        @csrf
        <div id="profile_container" class="js-masonry">
            @hook('tpl_user_edit_fields')
            @hook('tpl_pligg_profile_info_middle')

            <div class="masonry_wrapper">
                <table class="table table-bordered table-striped">
                    <thead class="table_title">
                        <tr>
                            <th colspan="2">{{ __('pligg.profile.modify_profile') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(in_array($userlevel, ['admin', 'moderator']))
                            <tr>
                                <td><label for="user_login">{{ __('pligg.register.username') }}:</label></td>
                                <td>
                                    <input type="text" class="form-control" name="user_login" 
                                           id="names" tabindex="1" value="{{ $user_login }}">
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td><label for="email">{{ __('pligg.profile.email') }}:</label></td>
                            <td>
                                <input type="text" class="form-control" name="email" 
                                       id="email" tabindex="3" value="{{ $user_email }}">
                                <br><div class="help-inline">{{ __('pligg.profile.only_admins') }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="public_email">{{ __('pligg.user.profile.public_email') }}:</label></td>
                            <td>
                                <input type="text" class="form-control" name="public_email" 
                                       id="public_email" tabindex="5" value="{{ $user_publicemail }}">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="url">{{ __('pligg.user.profile.homepage') }}:</label></td>
                            <td>
                                <input type="text" class="form-control" name="url" 
                                       id="url" tabindex="7" value="{{ $user_url }}">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="names">{{ __('pligg.profile.real_name') }}:</label></td>
                            <td>
                                <input type="text" class="form-control" name="names" 
                                       id="names" tabindex="1" value="{{ $user_names }}">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="occupation">{{ __('pligg.profile.occupation') }}:</label></td>
                            <td>
                                <input type="text" class="form-control" name="occupation" 
                                       id="occupation" tabindex="11" value="{{ $user_occupation }}">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="location">{{ __('pligg.profile.location') }}:</label></td>
                            <td>
                                <input type="text" class="form-control" name="location" 
                                       id="location" tabindex="9" value="{{ $user_location }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="masonry_wrapper">
                <table class="table table-bordered table-striped">
                    <thead class="table_title">
                        <tr>
                            <th colspan="2">{{ __('pligg.user.profile.social') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['skype', 'facebook', 'twitter', 'linkedin', 'googleplus', 'pinterest'] as $social)
                            <tr>
                                <td>
                                    <label for="{{ $social }}">
                                        {{ __("pligg.user.profile.{$social}") }}:
                                    </label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" 
                                           name="{{ $social }}" id="{{ $social }}" 
                                           value="{{ ${'user_'.$social} }}" 
                                           tabindex="{{ $loop->index * 2 + 2 }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @hook('tpl_pligg_profile_settings_start')

            <div class="masonry_wrapper">
                <table class="table table-bordered table-striped">
                    <thead class="table_title">
                        <tr>
                            <th colspan="2">{{ __('pligg.user.display_settings') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(config('pligg.user_language'))
                            <tr>
                                <td>
                                    <label>{{ __('pligg.user.profile.language') }}:</label>
                                </td>
                                <td>
                                    <select name="language" class="form-control site_languages">
                                        @foreach($languages as $lang)
                                            <option @selected($lang === $user_language)>
                                                {{ $lang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endif

                        @if(config('pligg.allow_user_change_templates') && count($templates) > 1)
                            <tr>
                                <td>
                                    <label>{{ __('pligg.user.setting.template') }}:</label>
                                </td>
                                <td>
                                    <select name="template" class="form-control site_template">
                                        @foreach($templates as $template)
                                            <option @selected($template === $current_template)>
                                                {{ ucfirst($template) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td>
                                <label>{{ __('pligg.user.setting.categories') }}:</label>
                            </td>
                            <td>
                                @foreach($category as $cat)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chack[]" 
                                                   value="{{ $cat->category__auto_id }}"
                                                   @checked(!in_array($cat->category__auto_id, $user_category))>
                                            {{ $cat->category_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @hook('tpl_pligg_profile_settings_end')

            <div class="masonry_wrapper">
                <table class="table table-bordered table-striped">
                    <thead class="table_title">
                        <tr>
                            <th colspan="2">{{ __('pligg.profile.change_pass') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><label>{{ __('pligg.profile.old_pass') }}:</label></td>
                            <td>
                                <input type="password" class="form-control" id="oldpassword" 
                                       name="oldpassword" tabindex="13">
                            </td>
                        </tr>
                        <tr>
                            <td><label>{{ __('pligg.profile.new_pass') }}:</label></td>
                            <td>
                                <input type="password" class="form-control" id="newpassword" 
                                       name="newpassword" tabindex="14">
                            </td>
                        </tr>
                        <tr>
                            <td><label>{{ __('pligg.profile.verify_new_pass') }}:</label></td>
                            <td>
                                <input type="password" class="form-control" id="verify" 
                                       name="newpassword2" tabindex="15">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="clear:both;"></div>
        <div class="form-actions">
            <input type="hidden" name="process" value="1">
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <input type="submit" name="save_profile" 
                   value="{{ __('pligg.profile.save') }}" 
                   class="btn btn-primary profile_settings_save" tabindex="16">
        </div>
    </form>

    @hook('tpl_pligg_profile_end')
@endsection
