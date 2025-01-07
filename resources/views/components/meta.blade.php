<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="@yield('meta_description', config('pligg.meta.description'))">
<meta name="keywords" content="@yield('meta_keywords', config('pligg.meta.keywords'))">
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta name="title" content="@yield('title', config('app.name')) - {{ config('pligg.meta.title_suffix', 'Social Bookmarking') }}">
<meta name="robots" content="@yield('meta_robots', 'index, follow')">

@if(config('pligg.meta.facebook.enabled', false))
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('img/og-default.jpg'))">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:description" content="@yield('og_description', config('pligg.meta.description'))">
@endif

@if(config('pligg.meta.twitter.enabled', false))
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="{{ config('pligg.meta.twitter.username') }}">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', config('pligg.meta.description'))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('img/twitter-default.jpg'))">
@endif

@stack('meta')
