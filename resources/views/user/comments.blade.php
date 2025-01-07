@extends('layouts.app')

@section('title', __('pligg.user.comments.title'))

@section('content')
    <div class="user_comment_history">
        <span class="user_comment_story_title">
            <a href="{{ $story_url }}">{{ $title_short }}</a>
        </span>
        
        <span class="user_comment_story_author">
            {{ __('pligg.by') }}
            @if(config('pligg.use_avatars'))
                <a href="{{ $submitter_profile_url }}">
                    <img class="user_comment_story_author_avatar" src="{{ $Avatar_ImgSrcs }}" />
                </a>
            @endif
            <a href="{{ $submitter_profile_url }}">{{ $link_submitter }}</a>
        </span>
        
        <span class="user_comment_story_timestamp">
            {{ $link_submit_timeago }} {{ __('pligg.comment.ago') }}
        </span>

        <div class="user_comment_data">
            <div class="user_comment_details">
                <span class="user_comment_author">
                    @if(config('pligg.use_avatars'))
                        <a href="{{ $user_view_url }}">
                            <img class="user_comment_comment_author_avatar" src="{{ $Avatar['small'] }}" />
                        </a>
                    @endif
                    <a href="{{ $user_view_url }}">{{ $user_username }}</a>
                </span>
                <span class="user_comment_timestamp">
                    {{ $comment_age }} {{ __('pligg.comment.ago') }}
                </span>
            </div>
            
            <div class="user_comment_content">
                @if(config('pligg.enable_comment_voting'))
                    @if($comment_user_vote_count == 0 && $current_userid != $comment_author)
                        <span id="ratebuttons-{{ $comment_id }}">
                            <a href="javascript:{{ $link_shakebox_javascript_voten }}" 
                               style="text-decoration:none;">-</a>
                            <a id="cvote-{{ $comment_id }}" 
                               style="text-decoration: none;">{{ $comment_votes }}</a>
                            <a href="javascript:{{ $link_shakebox_javascript_votey }}" 
                               style="text-decoration:none;">+</a>
                        </span>
                    @endif
                @endif
                
                <span class="user_comment_content">
                    {!! $comment_content !!}
                </span>
            </div>
        </div>
    </div>
@endsection
