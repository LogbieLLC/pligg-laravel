@if($moderatedLinks > 0 || $moderatedComments > 0)
    <div class="alert alert-warning">
        <p>
            @if($moderatedLinks > 0)
                <strong>
                    <a href="{{ route('admin.links.index', ['filter' => 'moderated']) }}" 
                       class="text-decoration-underline">
                        {{ trans_choice('pligg.moderation.stories_awaiting', $moderatedLinks, ['count' => $moderatedLinks]) }}
                    </a>
                </strong>
            @else
                {{ __('pligg.moderation.no_stories_awaiting') }}
            @endif

            @if($moderatedComments > 0)
                <strong>
                    <a href="{{ route('admin.comments.index', ['filter' => 'moderated']) }}" 
                       class="text-decoration-underline">
                        {{ trans_choice('pligg.moderation.comments_awaiting', $moderatedComments, ['count' => $moderatedComments]) }}
                    </a>
                </strong>
            @else
                {{ __('pligg.moderation.no_comments_awaiting') }}
            @endif
        </p>
    </div>
@endif
