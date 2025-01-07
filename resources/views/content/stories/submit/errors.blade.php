@extends('layouts.app')

@section('title', __('pligg.submit.errors.title'))

@section('content')
<fieldset>
    {{-- Submit Step 2 Errors --}}
    @if($submit_error === 'invalidurl')
        <div class="alert alert-danger">
            <p>
                {{ __('pligg.submit.errors.invalid_url') }}
                @if($submit_url === 'http://')
                    {{ __('pligg.submit.errors.invalid_url_specify') }}
                @else
                    : {{ $submit_url }}
                @endif
            </p>
            <form id="error-form">
                <button type="button" onclick="gPageIsOkToExit=true;window.history.go(-1);" 
                        class="btn btn-primary">
                    {{ __('pligg.submit.errors.back') }}
                </button>
            </form>
        </div>
    @endif

    @if($submit_error === 'dupeurl')
        <div class="alert alert-danger">
            <p>{{ __('pligg.submit.errors.dupe_url', ['url' => $submit_url]) }}</p>
            <p>{{ __('pligg.submit.errors.dupe_url_instruct') }}</p>
            <p>
                <a href="{{ $submit_search }}">
                    <strong>{{ __('pligg.submit.errors.dupe_url_instruct2') }}</strong>
                </a>
            </p>
            <form id="error-form">
                <button type="button" onclick="gPageIsOkToExit=true;window.history.go(-1);" 
                        class="btn btn-primary">
                    {{ __('pligg.submit.errors.back') }}
                </button>
            </form>
        </div>
    @endif

    @hook('tpl_pligg_submit_error_2')

    {{-- Submit Step 3 Errors --}}
    @foreach(['badkey', 'hashistory', 'urlintitle', 'incomplete', 'long_title', 
              'long_content', 'long_tags', 'short_tags', 'long_summary', 'nocategory'] as $error)
        @if($submit_error === $error)
            <div class="alert alert-danger">
                <p>{{ __("pligg.submit.errors.{$error}", ['history' => $submit_error_history ?? '']) }}</p>
                <form id="error-form">
                    <button type="button" 
                            onclick="gPageIsOkToExit=true; window.location.href='{{ route('stories.submit.edit', ['id' => $link_id]) }}';" 
                            class="btn btn-primary">
                        {{ __('pligg.submit.errors.back') }}
                    </button>
                </form>
            </div>
        @endif
    @endforeach

    @hook('tpl_pligg_submit_error_3')
</fieldset>
@endsection
