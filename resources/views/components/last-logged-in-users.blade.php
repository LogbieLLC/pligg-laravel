<div class="last-logged-in-users" 
     style="background-image:url('{{ asset('images/widgets/keys.jpg') }}'); 
            background-position:right top; 
            background-repeat:no-repeat;">

    <p style="margin-bottom:10px;">
        {{ __('pligg.widgets.last_logged_in.title', ['count' => $limit]) }}
    </p>

    <div style="margin:3px 0 12px 0;">
        <table class="table table-condensed table-striped" style="margin-bottom:0;">
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>
                            <span style="font-weight: bold; font-size: 10px; 
                                       color: {{ $user->is_new ? '#F09' : '#069' }}">
                                <a href="{{ route('user.profile', $user->user_login) }}" 
                                   target="_blank">{{ $user->user_login }}</a>
                            </span>
                        </td>
                        <td>
                            <span class="ttip" id="ttip{{ $index + 1 }}" 
                                  data-tooltip-content="#tooltip{{ $index + 1 }}">
                                {{ $user->last_login_relative }}
                            </span>
                            <div id="tooltip{{ $index + 1 }}" class="tooltip-content">
                                <table style="table-layout: fixed; width: 100%">
                                    <tr>
                                        <td><strong>{{ __('pligg.widgets.last_logged_in.last_in') }}:</strong></td>
                                        <td>{{ $user->user_lastlogin }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('pligg.widgets.last_logged_in.email') }}:</strong></td>
                                        <td>{{ $user->user_email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('pligg.widgets.last_logged_in.registered') }}:</strong></td>
                                        <td>{{ $user->user_date }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('pligg.widgets.last_logged_in.ip') }}:</strong></td>
                                        <td>{{ $user->user_ip }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('pligg.widgets.last_logged_in.recent_ip') }}:</strong></td>
                                        <td>{{ $user->user_lastip }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<style>
.ttip {
    cursor: help;
    font-size: 9px;
    font-family: arial;
    font-weight: bold;
}
.tooltip-content {
    display: none;
}
.tippy-box {
    font-size: 9px;
    border: 1px solid #FC9;
    background-color: #FFC;
    padding: 2px;
    width: 250px;
    border-radius: 7px;
}
td {
    word-wrap: break-word;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ttip').forEach(element => {
        const content = document.querySelector(element.dataset.tooltipContent);
        tippy(element, {
            content: content.innerHTML,
            allowHTML: true,
            theme: 'custom',
            placement: 'right',
            interactive: true
        });
    });
});
</script>
@endpush
