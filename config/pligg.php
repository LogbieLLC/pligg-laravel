<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Karma Settings
    |--------------------------------------------------------------------------
    |
    | These values determine the minimum karma required for various actions
    | within the system. Users must meet these thresholds to perform
    | specific actions like voting, submitting links, or commenting.
    |
    */

    'min_karma_vote' => env('PLIGG_MIN_KARMA_VOTE', 0),
    'min_karma_submit' => env('PLIGG_MIN_KARMA_SUBMIT', 0),
    'min_karma_comment' => env('PLIGG_MIN_KARMA_COMMENT', 0),

    /*
    |--------------------------------------------------------------------------
    | Karma Calculation Settings
    |--------------------------------------------------------------------------
    |
    | These settings control how karma is calculated and awarded throughout
    | the system. The multipliers affect how much karma is gained or lost
    | for various actions.
    |
    */

    'karma_vote_multiplier' => env('PLIGG_KARMA_VOTE_MULTIPLIER', 1),
    'karma_submit_multiplier' => env('PLIGG_KARMA_SUBMIT_MULTIPLIER', 5),
    'karma_comment_multiplier' => env('PLIGG_KARMA_COMMENT_MULTIPLIER', 2),

    /*
    |--------------------------------------------------------------------------
    | User Level Settings
    |--------------------------------------------------------------------------
    |
    | Define the various user levels and their corresponding karma thresholds.
    | Users will automatically be promoted to higher levels as they gain karma.
    |
    */

    'user_levels' => [
        'normal' => 0,
        'moderator' => 100,
        'admin' => 1000,
    ],

    /*
    |--------------------------------------------------------------------------
    | CSRF Protection Settings
    |--------------------------------------------------------------------------
    |
    | Configure CSRF token settings including expiration time and token
    | generation parameters. These settings ensure secure form submissions.
    |
    */

    'csrf_token_expiration' => env('PLIGG_CSRF_TOKEN_EXPIRATION', 60), // minutes
    'csrf_token_length' => env('PLIGG_CSRF_TOKEN_LENGTH', 40),
];
