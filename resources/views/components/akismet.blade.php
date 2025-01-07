<div class="akismet-widget">
    @if($spamLinksCount === 0)
        <div class="d-flex align-items-center mb-2">
            <img src="{{ $imagePath }}/tick.png" alt="No Spam" class="me-2" />
            {{ __('pligg.akismet.no_spam_stories') }}
        </div>
    @else
        <div class="d-flex align-items-center mb-2">
            <img src="{{ $imagePath }}/exclamation.png" alt="Spam Alert" class="me-2" />
            <a href="{{ route('admin.akismet.spam.stories') }}">
                {{ trans_choice('pligg.akismet.stories_need_review', $spamLinksCount, ['count' => $spamLinksCount]) }}
            </a>
        </div>
    @endif

    @if($spamCommentsCount === 0)
        <div class="d-flex align-items-center">
            <img src="{{ $imagePath }}/tick.png" alt="No Spam" class="me-2" />
            {{ __('pligg.akismet.no_spam_comments') }}
        </div>
    @else
        <div class="d-flex align-items-center">
            <img src="{{ $imagePath }}/exclamation.png" alt="Spam Alert" class="me-2" />
            <a href="{{ route('admin.akismet.spam.comments') }}">
                {{ trans_choice('pligg.akismet.comments_need_review', $spamCommentsCount, ['count' => $spamCommentsCount]) }}
            </a>
        </div>
    @endif
</div>
