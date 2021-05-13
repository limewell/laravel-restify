<?php

/**
 *  This is config file for laravel-restify
 *  https://github.com/limewell/laravel-restify
 *
 *  MIT License
 *
 *  Copyright (c) Limewell
 *
 *  You may obtain a copy of the License at:
 *  https://github.com/limewell/laravel-restify/blob/master/LICENSE.md
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Path To Model Directory
    |--------------------------------------------------------------------------
    |
    | Set this value to the path of your model directory
    | this is by default "app/Models" directory but if you created
    | Separated directory for model or use root path then give it's path
    | Example: 'app' or 'app/Data/Model' etc...
    |
    */
    'model_directory_path' => env('MODEL_DIRECTORY_PATH', 'app/Models'),

    /*
    |--------------------------------------------------------------------------
    | AddHeadersToApiRequest Middleware Configs
    |--------------------------------------------------------------------------
    |
    | This will add headers to api request like 'Accept:application/json' etc...
    |
    */
    'json_response' => env('API_JSON_RESPONSE', true),

    /*
    |--------------------------------------------------------------------------
    | Setting for Restify route
    |--------------------------------------------------------------------------
    |
    | Set route setting for restify
    |
    */
    'prefix' => 'restify',
    'middleware' => ['web', 'auth'],

];
