<div class="comment-form" id="comment-form">
    @hook('tpl_pligg_story_comment_form_start')
    <form action="{{ route('comments.store', $story) }}" method="POST" class="form">
        @csrf
        <input type="hidden" name="link_id" value="{{ $story->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        @if(isset($parentComment))
            <input type="hidden" name="parent_id" value="{{ $parentComment->id }}">
        @endif

        <div class="form-group">
            <label for="comment_content">{{ __('pligg.story.your_comment') }}</label>
            <textarea name="comment_content" id="comment_content" rows="6" 
                      class="form-control @error('comment_content') is-invalid @enderror"
                      required>{{ old('comment_content') }}</textarea>
            @error('comment_content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if(config('pligg.comment.enable_html', false))
            <p class="help-block">
                {{ __('pligg.story.html_tags_allowed') }}:
                {{ implode(', ', config('pligg.comment.allowed_tags', [])) }}
            </p>
        @endif

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                {{ __('pligg.story.submit_comment') }}
            </button>
        </div>
    </form>
    @hook('tpl_pligg_story_comment_form_end')
</div>
