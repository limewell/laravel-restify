<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Path To Model Directory
    |--------------------------------------------------------------------------
    |
    | Set this value to the path of your model directory
    | this is by default "app" directory but if you created
    | Separated directory for model then give it's path
    | Example: 'app/Model' or 'app/model' or 'app/Models' or 'app/Data/Model' etc...
    |
    */

    'model_directory_path' => env('MODEL_DIRECTORY_PATH', 'app/Models'),

    'allow_cross_origin' => env('API_ALLOW_CROSS_ORIGIN', true),
    'json_response' => env('API_JSON_RESPONSE', true),

    'prefix' => 'restify',
    'middleware' => ['web', 'auth'],

];
