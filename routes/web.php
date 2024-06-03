<?php

use Illuminate\Support\Facades\Route;
use App\Models\Area;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/register', function () {
    $areas = Area::all();
    return view('register', ['areas' => $areas]);
});
