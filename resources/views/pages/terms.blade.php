@extends('layouts.app')

@section('title', __('Terms of Service'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ __('Terms of Service') }}</h1>
            
            <div class="terms-content">
                {!! config('pligg.terms_content', 'Terms of service content goes here.') !!}
            </div>
        </div>
    </div>
</div>
@endsection
