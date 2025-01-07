@extends('layouts.app')

@section('title', __('Privacy Policy'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ __('Privacy Policy') }}</h1>
            
            <div class="privacy-content">
                {!! config('pligg.privacy_content', 'Privacy policy content goes here.') !!}
            </div>
        </div>
    </div>
</div>
@endsection
