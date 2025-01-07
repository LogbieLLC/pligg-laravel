@extends('layouts.app')

@section('title', __('pligg.groups.title'))

@section('content')
    @if(config('pligg.enable_group'))
        @if($pagename === 'groups')
            <div class="well group_explain">
                <div class="group_explain_inner">
                    <h2>{{ __('pligg.groups.header') }}</h2>
                    <div class="group_explain_description">
                        {{ __('pligg.group.explain') }}
                    </div>

                    @if(config('pligg.group.allow'))
                        <div class="create_group">
                            <form>
                                <input type="button" value="{{ __('pligg.submit.new_group') }}" 
                                       onclick="window.location.href='{{ route('groups.create') }}'" 
                                       class="btn btn-success">
                            </form>
                        </div>
                    @endif

                    <div class="search_groups">
                        <div class="input-append">
                            <form action="{{ route('groups.search') }}" method="get">
                                <input type="hidden" name="view" value="search">
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="keyword" 
                                           value="{{ $searchboxtext ?? '' }}" 
                                           placeholder="{{ __('pligg.search.default_text') }}">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('pligg.group.search_groups') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
        @endif

        @if(request('keyword'))
            @if($group_display)
                <legend>
                    {{ __('pligg.search.results', ['query' => request('keyword')]) }}
                </legend>
            @else
                <legend>
                    {{ __('pligg.search.no_results', ['query' => request('keyword')]) }}
                </legend>
            @endif
        @endif

        {!! $group_display !!}
        <div style="clear:both;"></div>
        {!! $group_pagination !!}
    @else
        <script type="text/javascript">
            window.location = "{{ route('error.404') }}";
        </script>
    @endif
@endsection
