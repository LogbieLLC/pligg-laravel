@extends('layouts.app')

@section('title', __('pligg.submit.step3.header'))

@section('content')
<div class="submit_page">
    <legend>{{ __('pligg.submit.step3.header') }}</legend>
    <h2>{{ __('pligg.submit.step3.details') }}</h2>
    
    @hook('tpl_pligg_submit_step3_start')

    @push('scripts')
    <script>
        // Variable toggles exit confirmation on and off
        var gPageIsOkToExit = false;

        function submitStory() {
            // Set variable so exit handler knows not to verify exit
            gPageIsOkToExit = true;
            document.getElementById('submit-form').submit();
        }

        window.onbeforeunload = function(event) {
            if (gPageIsOkToExit) return;

            if (!event && window.event) {
                event = window.event;
            }
            
            return "{{ __('pligg.submit.step3.unsaved_warning') }}";
        }
    </script>
    @endpush

    @include('content.stories.partials.story-card', ['story' => $story])

    <form action="{{ route('stories.submit') }}" method="post" id="submit-form">
        @csrf
        <input type="hidden" name="phase" value="3" />
        <input type="hidden" name="randkey" value="{{ $randkey }}" />
        <input type="hidden" name="id" value="{{ $submit_id }}" />
        <input type="hidden" name="trackback" value="{{ $trackback }}" />
        
        <br style="clear: both;" />
        <hr />
        
        
        <div class="text-center">
            <button type="button" onclick="gPageIsOkToExit = true; window.location.href='{{ route('stories.submit.edit', ['id' => $submit_id, 'trackback' => $trackback]) }}'" 
                    class="btn btn-default">
                {{ __('pligg.submit.step3.modify') }}
            </button>
            
            <button type="button" onclick="submitStory()" class="btn btn-primary">
                {{ __('pligg.submit.step3.submit_story') }}
            </button>
        </div>

        @hook('tpl_pligg_submit_step3_end')
    </form>

    @hook('tpl_submit_step_3_end')
</div>
@endsection
