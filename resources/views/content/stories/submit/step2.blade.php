@extends('layouts.app')

@section('title', __('pligg.submit.step2.details'))

@section('content')
<div class="submit_page">
    <legend>{{ __('pligg.submit.step2.details') }}</legend>
    @hook('tpl_pligg_submit_step2_start')

    <form class="form-horizontal" action="{{ route('stories.submit') }}" method="post" 
          name="submit-form" id="submit-form" enctype="multipart/form-data" 
          onsubmit="return checkForm()">
        @csrf
        <div class="col-md-6 submit_step_2_left">
            <div class="control-group">
                <label for="title" class="control-label">{{ __('pligg.submit.step2.title') }}</label>
                <div class="controls">
                    <input type="text" id="title" class="form-control title col-md-4" 
                           tabindex="1" name="title" 
                           value="{{ old('title', $submit_title ?? $submit_url_title ?? '') }}" 
                           maxlength="{{ config('pligg.max_title_length') }}" />
                    <p class="help-inline">{{ __('pligg.submit.step2.title_instruct') }}</p>
                </div>
            </div>

            <div class="control-group">
                <label for="category" class="control-label">{{ __('pligg.submit.step2.category') }}</label>
                <div class="controls select-category{{ config('pligg.multiple_categories') ? ' multi-select-category' : '' }}">
                    @if(config('pligg.multiple_categories'))
                        @foreach($categories as $category)
                            {!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->level) !!}
                            <input type="checkbox" class="form-control" name="category[]" 
                                   value="{{ $category->id }}" 
                                   @if($category->id == $submit_category || in_array($category->id, $submit_additional_cats ?? [])) checked @endif>
                            <span class="multi-cat">{{ $category->name }}</span>
                        @endforeach
                    @else
                        <select id="category" class="form-control category" tabindex="2" 
                                name="category" onchange="updateCategory(this)">
                            <option value="">{{ __('pligg.submit.step2.cat_select') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if($category->id == $submit_category || in_array($category->id, $submit_additional_cats ?? [])) selected @endif>
                                    {!! str_repeat('&nbsp;&nbsp;&nbsp;', $category->level) !!}
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    <p class="help-inline">{{ __('pligg.submit.step2.cat_instruct') }}</p>
                </div>
            </div>

            @if(config('pligg.enable_group') && isset($groups))
                <div class="control-group">
                    <label class="control-label">{{ __('pligg.group.submit_story') }}</label>
                    <div class="controls">
                        @include('content.stories.submit.partials.group-select')
                    </div>
                </div>
            @endif

            @hook('tpl_header_admin_main_comment_subscription')

            @if(config('pligg.enable_tags'))
                <div class="control-group">
                    <label for="tags" class="control-label">{{ __('pligg.submit.step2.tags') }}</label>
                    <div class="controls">
                        <input tabindex="10" type="text" id="tags" 
                               class="form-control tags col-md-4" name="tags" 
                               data-mode="multiple" value="{{ $tags_words ?? '' }}" 
                               maxlength="{{ config('pligg.max_tags_length') }}" />
                        <p class="help-inline">
                            {{ __('pligg.submit.step2.tags_example') }} 
                            {{ __('pligg.submit.step2.tags_inst2') }}
                        </p>
                    </div>
                </div>
            @endif

            @hook('tpl_pligg_submit_step2_middle')

            <div class="control-group">
                <label for="bodytext" class="control-label">{{ __('pligg.submit.step2.description') }}</label>
                <div class="controls">
                    <textarea name="bodytext" tabindex="15" rows="6" 
                              class="form-control bodytext col-md-4" id="bodytext" 
                              maxlength="{{ config('pligg.max_story_length') }}" 
                              wrap="soft">{{ $submit_url_description ?? $submit_content ?? '' }}</textarea>
                    <p class="help-inline">{{ __('pligg.submit.step2.desc_instruct') }}</p>
                </div>
            </div>

            @if(config('pligg.submit.summary_allow_edit'))
                <div class="control-group">
                    <label for="summarytext" class="control-label">{{ __('pligg.submit.step2.summary') }}</label>
                    <div class="controls">
                        <textarea name="summarytext" rows="5" 
                                  maxlength="{{ config('pligg.max_summary_length') }}" 
                                  id="summarytext" class="col-md-4" 
                                  wrap="soft">{{ $submit_summary ?? '' }}</textarea>
                        <p class="help-inline">
                            {{ __('pligg.submit.step2.summary_instruct') }}
                            {{ __('pligg.submit.step2.summary_limit') }}
                            {{ config('pligg.story_summary_truncate') }}
                            {{ __('pligg.submit.step2.summary_limit_chars') }}
                        </p>
                    </div>
                </div>
            @endif

            @hook('submit_step_2_pre_extrafields')
            @include('content.stories.submit.partials.extra-fields')

            <div class="form-actions">
                <input type="hidden" name="url" id="url" value="{{ $submit_url }}" />
                <input type="hidden" name="phase" value="2" />
                <input type="hidden" name="randkey" value="{{ $randkey }}" />
                <input type="hidden" name="id" value="{{ $submit_id }}" />
                
                <button class="btn btn-default" tabindex="30" onclick="history.go(-1)">
                    {{ __('pligg.cancel') }}
                </button>
                
                @hook('tpl_pligg_submit_step2_end')
                
                <input class="btn btn-primary" tabindex="31" type="submit" 
                       value="{{ __('pligg.submit.step2.continue') }}" />
            </div>
        </div>

        <div class="col-md-6 submit_step_2_right" id="dockcontent">
            @hook('tpl_pligg_submit_preview_start')
            @include('content.stories.submit.partials.preview')
        </div>
    </form>
</div>

@push('scripts')
<script>
function updateCategory(select) {
    if (select.selectedIndex > 0) {
        $('#lp-category').text(select.options[select.selectedIndex].text);
    } else {
        $('#lp-category').text('');
    }
}

function checkForm() {
    // Add your form validation logic here
    return true;
}
</script>
@endpush
@endsection
