<?php

use Illuminate\Support\Facades\Route;

Route::get('/rss', function () {
    return response()->view('rss.index', [
        'stories' => \App\Models\Link::where('status', 'published')
            ->latest('published_at')
            ->limit(50)
            ->get()
    ])->header('Content-Type', 'application/rss+xml');
})->name('rss.index');
