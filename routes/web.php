<?php
Route::get('/', function (\Illuminate\Http\Request $request) {
    return view('laravel-restify::welcome');
});
