@forelse($comments as $comment)
    <li class="media comment-item" id="comment-{{ $comment->id }}">
        @if(config('pligg.use_avatars', true))
            <div class="media-left">
                <a href="{{ route('user.profile', $comment->user->username) }}" class="avatar-tooltip"
                   rel="tooltip" title="{{ $comment->user->username }}">
                    <img src="{{ $comment->user->avatar_url }}" class="media-object" alt="">
                </a>
            </div>
        @endif

        <div class="media-body">
            <div class="comment-content">
                <div class="comment-data">
                    <span class="comment-author">
                        <a href="{{ route('user.profile', $comment->user->username) }}">
                            {{ $comment->user->username }}
                        </a>
                    </span>
                    <span class="comment-date">
                        {{ $comment->created_at->diffForHumans() }}
                    </span>
                    @if($comment->is_edited)
                        <span class="comment-edited">
                            ({{ __('pligg.story.comment_edited') }})
                        </span>
                    @endif
                </div>

                <div class="comment-text">
                    {!! $comment->content !!}
                </div>

                <div class="comment-footer">
                    @auth
                        <div class="comment-actions">
                            @can('vote', $comment)
                                <button class="btn btn-xs btn-default vote-comment" 
                                        data-comment-id="{{ $comment->id }}"
                                        data-vote="up">
                                    <i class="fa fa-thumbs-up"></i>
                                    <span class="vote-count">{{ $comment->votes_up }}</span>
                                </button>
                                <button class="btn btn-xs btn-default vote-comment"
                                        data-comment-id="{{ $comment->id }}"
                                        data-vote="down">
                                    <i class="fa fa-thumbs-down"></i>
                                    <span class="vote-count">{{ $comment->votes_down }}</span>
                                </button>
                            @endcan

                            <button class="btn btn-xs btn-default reply-comment" 
                                    onclick="showReplayCommentForm({{ $comment->id }})">
                                <i class="fa fa-reply"></i> {{ __('pligg.story.reply') }}
                            </button>

                            @can('update', $comment)
                                <a href="{{ route('comments.edit', $comment) }}" 
                                   class="btn btn-xs btn-default">
                                    <i class="fa fa-edit"></i> {{ __('pligg.story.edit') }}
                                </a>
                            @endcan

                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger"
                                            onclick="return confirm('{{ __('pligg.story.confirm_delete') }}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    @endauth

                    <div id="comment-reply-{{ $comment->id }}" class="comment-reply-form" style="display: none;">
                        @include('content.stories.partials.comment-form', ['parentComment' => $comment])
                    </div>
                </div>
            </div>

            @if($comment->replies->count() > 0)
                <ol class="media-list comment-replies">
                    @include('content.stories.partials.comments', ['comments' => $comment->replies])
                </ol>
            @endif
        </div>
    </li>
@empty
    <li class="no-comments">
        <p>{{ __('pligg.story.no_comments') }}</p>
    </li>
@endforelse
