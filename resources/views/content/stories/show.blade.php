@extends('layouts.app')

@section('title', $story->title)

@section('content')
{{-- Story Wrapper Template --}}
@hook('tpl_pligg_content_start')

@include('content.stories.partials.story-card', ['story' => $story])

<ul class="nav nav-tabs" id="storytabs">
    <li class="active">
        <a data-toggle="tab" href="#comments">
            <i class="fa fa-comments"></i> {{ __('pligg.story.comments') }}
        </a>
    </li>
    @if($voters->count() > 0)
        <li>
            <a data-toggle="tab" href="#who_voted">
                <i class="fa fa-thumbs-up"></i> {{ __('pligg.story.who_upvoted') }}
            </a>
        </li>
    @endif
    @if($downvoters->count() > 0)
        <li>
            <a data-toggle="tab" href="#who_downvoted">
                <i class="fa fa-thumbs-down"></i> {{ __('pligg.story.who_downvoted') }}
            </a>
        </li>
    @endif
    @if($relatedStories->count() > 0)
        <li>
            <a data-toggle="tab" href="#related">
                <i class="fa fa-tag"></i> {{ __('pligg.story.related') }}
            </a>
        </li>
    @endif
    @hook('tpl_pligg_story_tab_end')
</ul>

@push('scripts')
<script>
    const storyLink = "{{ $story->url }}";

    $(function () {
        $('#storytabs a[href="#who_voted"]').tab('show');
        $('#storytabs a[href="#who_downvoted"]').tab('show');
        $('#storytabs a[href="#related"]').tab('show');
        $('#storytabs a[href="#comments"]').tab('show');
    });

    @if(config('pligg.url_method') == 2)
        function showComments(id) {
            window.location.href = `${storyLink}/${id}#comment-${id}`;
        }
        function showReplayCommentForm(id) {
            window.location.href = `${storyLink}/reply/${id}#comment-reply-${id}`;
        }
    @else
        function showComments(id) {
            window.location.href = `${storyLink}&comment_id=${id}#comment-${id}`;
        }
        function showReplayCommentForm(id) {
            window.location.href = `${storyLink}&comment_id=${id}&reply=1#comment-reply-${id}`;
        }
    @endif
</script>
@endpush

<div id="tabbed" class="tab-content">
    <div class="tab-pane fade active in" id="comments">
        @hook('tpl_pligg_story_comments_start')
        <h3>{{ __('pligg.story.comments') }}</h3>
        <a name="comments" href="#comments"></a>
        <ol class="media-list comment-list">
            @hook('tpl_pligg_story_comments_individual_start')
            @include('content.stories.partials.comments', ['comments' => $comments])
            @hook('tpl_pligg_story_comments_individual_end')
            
            @auth
                @include('content.stories.partials.comment-form')
            @else
                @hook('anonymous_comment_form_start')
                <div class="text-center login_to_comment">
                    <br>
                    <h3>
                        <a href="{{ route('login') }}">{{ __('pligg.story.login_to_comment') }}</a>
                        {{ __('pligg.story.register') }}
                        <a href="{{ route('register') }}">{{ __('pligg.story.register_here') }}</a>.
                    </h3>
                </div>
                @hook('anonymous_comment_form_end')
            @endauth
        </ol>
        @hook('tpl_pligg_story_comments_end')
    </div>

    @if($voters->count() > 0)
        <div class="tab-pane fade" id="who_voted">
            <h3>{{ __('pligg.story.who_voted') }}</h3>
            @hook('tpl_pligg_story_who_voted_start')
            <div class="whovotedwrapper whoupvoted">
                <ul>
                    @foreach($voters as $voter)
                        <li>
                            @if(config('pligg.use_avatars', true))
                                <a href="{{ route('user.profile', $voter->username) }}" 
                                   rel="tooltip" 
                                   title="{{ $voter->username }}" 
                                   class="avatar-tooltip">
                                    <img src="{{ $voter->avatar_url }}" alt="" title="">
                                </a>
                            @else
                                <a href="{{ route('user.profile', $voter->username) }}">
                                    {{ $voter->username }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            @hook('tpl_pligg_story_who_voted_end')
        </div>
    @endif

    @if($downvoters->count() > 0)
        <div class="tab-pane fade" id="who_downvoted">
            <h3>{{ __('pligg.story.who_downvoted') }}</h3>
            @hook('tpl_pligg_story_who_downvoted_start')
            <div class="whovotedwrapper whodownvoted">
                <ul>
                    @foreach($downvoters as $downvoter)
                        <li>
                            @if(config('pligg.use_avatars', true))
                                <a href="{{ route('user.profile', $downvoter->username) }}"
                                   rel="tooltip"
                                   title="{{ $downvoter->username }}"
                                   class="avatar-tooltip">
                                    <img src="{{ $downvoter->avatar_url }}" alt="" title="">
                                </a>
                            @else
                                <a href="{{ route('user.profile', $downvoter->username) }}">
                                    {{ $downvoter->username }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="clearfix"></div>
            @hook('tpl_pligg_story_who_downvoted_end')
        </div>
    @endif

    @if($relatedStories->count() > 0)
        <div class="tab-pane fade" id="related">
            <h3>{{ __('pligg.story.related') }}</h3>
            @hook('tpl_pligg_story_related_start')
            <ol>
                @foreach($relatedStories->take(10) as $relatedStory)
                    <li>
                        <a href="{{ $relatedStory->url }}">{{ $relatedStory->title }}</a>
                    </li>
                @endforeach
            </ol>
            @hook('tpl_pligg_story_related_end')
        </div>
    @endif

    @hook('tpl_pligg_story_tab_end_content')
</div>
@endsection
