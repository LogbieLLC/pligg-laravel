@hook('tpl_pligg_admin_stats_widget_start')

<table class="table table-condensed table-striped" style="margin-bottom:0;">
    @if(config('pligg.statistics.show_version', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.version') }}:</strong>
            </td>
            <td>{{ $version_number }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_members', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.members') }}:</strong>
            </td>
            <td>{{ $members }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_groups', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.groups') }}:</strong>
            </td>
            <td>{{ $grouptotal }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_submissions', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.submissions') }}:</strong>
            </td>
            <td>{{ $total }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_published', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.published') }}:</strong>
            </td>
            <td>{{ $published_submissions_count }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_new', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.new') }}:</strong>
            </td>
            <td>{{ $new_submissions_count }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_votes', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.votes') }}:</strong>
            </td>
            <td>{{ $votes }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_comments', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.comments') }}:</strong>
            </td>
            <td>{{ $comments }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_member', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.latest_member') }}:</strong>
            </td>
            <td>
                <a href="{{ route('user.profile', $last_user) }}" 
                   title="{{ __('pligg.statistics.latest_user') }}">{{ $last_user }}</a>
            </td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_php_version', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.php_version') }}:</strong>
            </td>
            <td>{{ $php_version }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_mysql_version', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.mysql_version') }}:</strong>
            </td>
            <td>{{ $mysql_version }}</td>
        </tr>
    @endif

    @if(config('pligg.statistics.show_dbsize', true))
        <tr>
            <td>
                <strong>{{ __('pligg.statistics.dbsize') }}:</strong>
            </td>
            <td>{{ $dbsize }}</td>
        </tr>
    @endif

    @hook('tpl_pligg_admin_stats_widget_intable')
</table>

@hook('tpl_pligg_admin_stats_widget_end')
