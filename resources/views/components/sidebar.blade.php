<div class="sidebar-module">
    @auth
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Your Stats') }}</h3>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>{{ __('Karma') }}: {{ number_format(auth()->user()->karma, 2) }}</li>
                    <li>{{ __('Submitted Stories') }}: {{ auth()->user()->links()->count() }}</li>
                    <li>{{ __('Comments') }}: {{ auth()->user()->comments()->count() }}</li>
                    <li>{{ __('Votes') }}: {{ auth()->user()->votes()->count() }}</li>
                </ul>
            </div>
        </div>
    @endauth

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ __('Top Users') }}</h3>
        </div>
        <div class="panel-body">
            @foreach($topUsers as $user)
                <div class="media">
                    <div class="media-left">
                        <img class="media-object avatar-tooltip" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                             data-toggle="tooltip" title="{{ $user->name }}" width="32" height="32">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="{{ route('user.profile', $user->username) }}">{{ $user->name }}</a>
                        </h4>
                        <small>{{ __('Karma') }}: {{ number_format($user->karma, 2) }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if(config('pligg.show_tags_sidebar', true))
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Popular Tags') }}</h3>
            </div>
            <div class="panel-body">
                @foreach($popularTags as $tag)
                    <a href="{{ route('tag.show', $tag->words) }}" class="label label-default" 
                       style="font-size: {{ 100 + ($tag->count * 10) }}%">
                        {{ $tag->words }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
