@extends('layouts.app')

@section('title', __('Registration Complete'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @hook('tpl_pligg_register_complete_start')
            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ __('pligg.register.complete') }}</h3>
                </div>
                <div class="panel-body">
                    <p>
                        {!! __('pligg.register.thankyou', ['user' => request('user')]) !!}
                        {!! __('pligg.register.noemail') !!}
                        {!! __('pligg.register.todo', ['email' => config('pligg.email.from')]) !!}
                    </p>
                </div>
            </div>

            @hook('tpl_pligg_register_complete_end')
        </div>
    </div>
</div>
@endsection
