@extends('layouts.app')

@section('title', __('pligg.submit.step1.header'))

@section('content')
<legend>{{ __('pligg.submit.step1.header') }}</legend>
<div class="submit">
    <h3>{{ __('pligg.submit.step1.instructions') }}</h3>
    @hook('tpl_pligg_submit_step1_start')
    
    <div class="submit_instructions">
        <ul class="instructions">
            @if(config('pligg.submit.instructions.1a'))
                <li><strong>{{ __('pligg.submit.step1.instruct_1a') }}:</strong> {{ __('pligg.submit.step1.instruct_1b') }}</li>
            @endif
            @if(config('pligg.submit.instructions.2a'))
                <li><strong>{{ __('pligg.submit.step1.instruct_2a') }}:</strong> {{ __('pligg.submit.step1.instruct_2b') }}</li>
            @endif
            @if(config('pligg.submit.instructions.3a'))
                <li><strong>{{ __('pligg.submit.step1.instruct_3a') }}:</strong> {{ __('pligg.submit.step1.instruct_3b') }}</li>
            @endif
            @if(config('pligg.submit.instructions.4a'))
                <li><strong>{{ __('pligg.submit.step1.instruct_4a') }}:</strong> {{ __('pligg.submit.step1.instruct_4b') }}</li>
            @endif
            @if(config('pligg.submit.instructions.5a'))
                <li><strong>{{ __('pligg.submit.step1.instruct_5a') }}:</strong> {{ __('pligg.submit.step1.instruct_5b') }}</li>
            @endif
            @if(config('pligg.submit.instructions.6a'))
                <li><strong>{{ __('pligg.submit.step1.instruct_6a') }}:</strong> {{ __('pligg.submit.step1.instruct_6b') }}</li>
            @endif
            @if(config('pligg.submit.instructions.7a'))
                <li><strong>{{ __('pligg.submit.step1.instruct_7a') }}:</strong> {{ __('pligg.submit.step1.instruct_7b') }}</li>
            @endif
        </ul>
    </div>

    @hook('tpl_pligg_submit_step1_middle')

    <form action="{{ config('pligg.url_method') == 2 ? route('stories.submit') : url('submit.php') }}" 
          method="post" class="form-inline" id="submit-form">
        @csrf
        <h3>{{ __('pligg.submit.step1.news_source') }}</h3>
        <label for="url">{{ __('pligg.submit.step1.news_url') }}:</label>
        <div class="row">
            <div class="col-md-5 form-group">
                <input autofocus type="text" name="url" class="form-control col-md-12" 
                       id="url" placeholder="http://" value="{{ old('url') }}" />
            </div>
            <div class="col-md-2 form-group">
                <input type="hidden" name="phase" value="1">
                <input type="hidden" name="randkey" value="{{ $submit_rand }}">
                <input type="hidden" name="id" value="c_1">
                <input type="submit" value="{{ __('pligg.submit.step1.continue') }}" 
                       class="col-md-12 btn btn-primary" />
            </div>
        </div>
        @hook('tpl_pligg_submit_step1_end')
    </form>

    <hr />

    <div class="bookmarklet">
        <h3>{{ __('pligg.user.profile.bookmarklet_title') }}</h3>
        <p>
            {{ __('pligg.user.profile.bookmarklet_title_1') }} 
            {{ config('app.name') }}.
            {{ __('pligg.user.profile.bookmarklet_title_2') }}
        </p>
        <p>
            <strong>{{ __('pligg.user.profile.ie') }}:</strong> 
            {{ __('pligg.user.profile.ie_1') }}
        </p>
        <p>
            <strong>{{ __('pligg.user.profile.firefox') }}:</strong> 
            {{ __('pligg.user.profile.firefox_1') }}
        </p>
        <p>
            <strong>{{ __('pligg.user.profile.opera') }}:</strong> 
            {{ __('pligg.user.profile.opera_1') }}
        </p>
        <p>
            <strong>{{ __('pligg.user.profile.the_bookmarklet') }}:</strong>
            @include('components.bookmarklet')
        </p>
    </div>
</div>
@endsection
