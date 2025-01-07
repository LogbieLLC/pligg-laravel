@extends('layouts.app')

@section('title', __('pligg.groups.view_group'))

@section('content')
    @if(config('pligg.enable_group'))
        @hook('tpl_pligg_group_start')
        @include('groups.partials.summary')
        @hook('tpl_pligg_group_end')

        <ul id="storytabs" class="nav nav-tabs">
            @hook('tpl_pligg_group_sort_start')
            <li @class(['active' => $groupview === 'published'])>
                <a href="{{ $groupview_published }}">
                    <span>{{ __('pligg.group.published') }}</span>
                    @if($group_published_rows)
                        <span class="badge badge-gray">{{ $group_published_rows }}</span>
                    @endif
                </a>
            </li>
            <li @class(['active' => $groupview === 'new'])>
                <a href="{{ $groupview_new }}">
                    <span>{{ __('pligg.group.new') }}</span>
                    @if($group_new_rows)
                        <span class="badge badge-gray">{{ $group_new_rows }}</span>
                    @endif
                </a>
            </li>
            <li @class(['active' => $groupview === 'shared'])>
                <a href="{{ $groupview_sharing }}">
                    <span>{{ __('pligg.group.shared') }}</span>
                    @if($group_shared_rows)
                        <span class="badge badge-gray">{{ $group_shared_rows }}</span>
                    @endif
                </a>
            </li>
            <li @class(['active' => $groupview === 'members'])>
                <a href="{{ $groupview_members }}">
                    <span class="active">{{ __('pligg.group.member') }}</span>
                </a>
            </li>
            @hook('tpl_pligg_group_sort_end')
        </ul>

        <div class="tab-content" id="tabbed">
            @if($groupview === 'published' || $groupview === 'new')
                {!! $group_display !!}
                <div style="clear:both;"></div>
                {!! $group_story_pagination !!}
            @elseif($groupview === 'shared')
                {!! $group_shared_display !!}
                <div style="clear:both;"></div>
                {!! $group_story_pagination !!}
            @elseif($groupview === 'members')
                <br />
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:32px">&nbsp;</th>
                            <th>{{ __('pligg.username') }}</th>
                            @if($is_group_admin)
                                <th style="width:100px;">{{ __('pligg.role') }}</th>
                                <th style="width:75px;">{{ __('pligg.edit') }}</th>
                                <th style="width:105px;">{{ __('pligg.activation') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        {!! $member_display !!}
                    </tbody>
                </table>
            @endif
        </div>
    @endif
@endsection
