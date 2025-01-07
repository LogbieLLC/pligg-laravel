@extends('layouts.app')

@section('title', __('pligg.tags.title'))

@section('content')
    <legend>{{ __('pligg.tags.header') }}</legend>
    <div id="tagcloud" style="line-height: {{ $tags_max_pts }}px;">
        @foreach($tags as $index => $tag)
            <span style="font-size: {{ number_format($tag_size[$index], 0) }}px" 
                  class="cloud_size_{{ number_format($tag_size[$index]) }}">
                <a href="{{ $tag_url[$index] }}">{{ $tag_name[$index] }}</a>
            </span>&nbsp;
        @endforeach
    </div>
@endsection
