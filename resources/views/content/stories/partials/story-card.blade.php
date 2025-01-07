<article class="story" id="story-{{ $story->id }}">
    @hook('tpl_pligg_story_start')
    
    <header class="story-header">
        <h1 class="story-title">
            <a href="{{ $story->url }}" rel="nofollow" target="_blank">
                {{ $story->title }}
            </a>
        </h1>

        <div class="story-meta">
            <span class="story-author">
                {{ __('pligg.story.submitted_by') }}
                <a href="{{ route('user.profile', $story->user->username) }}">
                    {{ $story->user->username }}
                </a>
            </span>

            <span class="story-date">
                {{ $story->created_at->diffForHumans() }}
            </span>

            @if($story->category)
                <span class="story-category">
                    {{ __('pligg.story.in') }}
                    <a href="{{ route('category.show', $story->category->slug) }}">
                        {{ $story->category->name }}
                    </a>
                </span>
            @endif

            <span class="story-stats">
                <i class="fa fa-comments"></i> {{ $story->comments_count }}
                <i class="fa fa-thumbs-up"></i> {{ $story->votes_up }}
                @if(config('pligg.enable_down_votes', true))
                    <i class="fa fa-thumbs-down"></i> {{ $story->votes_down }}
                @endif
            </span>
        </div>
    </header>

    <div class="story-content">
        @if($story->thumbnail)
            <div class="story-thumbnail">
                <img src="{{ $story->thumbnail }}" alt="{{ $story->title }}">
            </div>
        @endif

        <div class="story-description">
            {!! $story->description !!}
        </div>

        @if($story->tags->count() > 0)
            <div class="story-tags">
                <i class="fa fa-tags"></i>
                @foreach($story->tags as $tag)
                    <a href="{{ route('tag.show', $tag->slug) }}" class="label label-default">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <footer class="story-footer">
        @auth
            <div class="story-actions">
                @can('vote', $story)
                    <button class="btn btn-default vote-story" 
                            data-story-id="{{ $story->id }}"
                            data-vote="up">
                        <i class="fa fa-thumbs-up"></i> {{ __('pligg.story.vote_up') }}
                    </button>

                    @if(config('pligg.enable_down_votes', true))
                        <button class="btn btn-default vote-story"
                                data-story-id="{{ $story->id }}"
                                data-vote="down">
                            <i class="fa fa-thumbs-down"></i> {{ __('pligg.story.vote_down') }}
                        </button>
                    @endif
                @endcan

                @can('update', $story)
                    <a href="{{ route('stories.edit', $story) }}" class="btn btn-default">
                        <i class="fa fa-edit"></i> {{ __('pligg.story.edit') }}
                    </a>
                @endcan

                @can('delete', $story)
                    <form action="{{ route('stories.destroy', $story) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('{{ __('pligg.story.confirm_delete') }}')">
                            <i class="fa fa-trash"></i> {{ __('pligg.story.delete') }}
                        </button>
                    </form>
                @endcan

                @if(config('pligg.enable_save_story', true))
                    <button class="btn btn-default save-story"
                            data-story-id="{{ $story->id }}">
                        <i class="fa fa-bookmark"></i>
                        {{ $story->is_saved ? __('pligg.story.unsave') : __('pligg.story.save') }}
                    </button>
                @endif

                @if(config('pligg.enable_share', true))
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" 
                                data-toggle="dropdown">
                            <i class="fa fa-share"></i> {{ __('pligg.story.share') }}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($story->url) }}&text={{ urlencode($story->title) }}"
                                   target="_blank">
                                    <i class="fa fa-twitter"></i> Twitter
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($story->url) }}"
                                   target="_blank">
                                    <i class="fa fa-facebook"></i> Facebook
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        @endauth
    </footer>

    @hook('tpl_pligg_story_end')
</article>
