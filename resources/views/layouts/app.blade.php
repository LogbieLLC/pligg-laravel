<!DOCTYPE html>
<html class="no-js" dir="{{ config('pligg.visual.language_direction', 'ltr') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('components.meta')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.no-icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.pnotify.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" media="screen">
    @if(config('pligg.voting_method') == 2)
        <link rel="stylesheet" type="text/css" href="{{ asset('css/star_rating/star.css') }}" media="screen">
    @endif

    <script type="text/javascript" src="{{ asset('js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.7.1.js') }}"></script>

    @stack('styles')
    @stack('head-scripts')

    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="{{ route('rss.index') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>
<body dir="{{ config('pligg.visual.language_direction', 'ltr') }}" class="{{ $bodyClass ?? '' }}">
    @if(config('pligg.maintenance_mode') && !auth()->user()?->isAdmin())
        @include('maintenance')
    @else
        @if(config('pligg.maintenance_mode') && auth()->user()?->isAdmin())
            <div class="alert alert-danger" style="margin-bottom:0;">
                <button class="close" data-dismiss="alert">&times;</button>
                {{ __('pligg.maintenance.admin_warning') }}
            </div>
        @endif

        @include('layouts.navigation')
        @include('components.categories')

        <div class="container">
            <section id="maincontent">
                <div class="row">
                    @if(request()->routeIs(['submit.*', 'user.*', 'profile.*', 'auth.*']))
                        <div class="col-md-12">
                    @else
                        <div class="col-md-9">
                    @endif
                        @include('components.breadcrumb')
                        {{ $slot }}
                    </div>

                    @unless(request()->routeIs(['submit.*', 'user.*', 'profile.*', 'auth.*']))
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div id="rightcol" class="panel-body">
                                    @include('components.sidebar')
                                </div>
                            </div>
                        </div>
                    @endunless
                </div>
            </section>

            @if(config('pligg.auto_scroll') != 2)
                <hr>
                <footer class="footer">
                    @include('layouts.footer')
                </footer>
            @endif
        </div>

        @stack('modals')
        @stack('scripts')

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" 
                integrity="sha384-4D3G3GikQs6hLlLZGdz5wLFzuqE9v4yVGAcOH86y23JqBDPzj9viv0EqyfIa6YUL" 
                crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.pnotify.min.js') }}"></script>
    @endif
</body>
</html>
