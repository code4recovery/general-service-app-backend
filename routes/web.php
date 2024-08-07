<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserIsAdmin;
use App\Models\Entity;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

# set the app locale based on the user's preferred language
$lang = Request::getPreferredLanguage(['en', 'es', 'fr']);
if ($lang) {
    Config::set('app.locale', $lang);
}

Route::view('/', 'home')->name('home');

Route::view('/privacy', 'privacy')->name('privacy');

Route::view('/login', 'login')->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::get('/verify-login/{token}', [UserController::class, 'verifyLogin'])->name('verify-login');

Route::get('/logout', [UserController::class, 'logout']);

Route::view('/map', 'map')->name('map');

# Authenticated Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('entities', EntityController::class);
    Route::resource('entities.stories', StoryController::class);
    Route::resource('entities.links', LinkController::class);

    Route::get('/delete-entity/{entity}', [EntityController::class, 'destroy'])->name('delete-entity');
    Route::get('/delete-link/{link}', [LinkController::class, 'destroy'])->name('delete-link');
    Route::get('/delete-story/{story}', [StoryController::class, 'destroy'])->name('delete-story');

    Route::post('/reorder-links/{entity}', [LinkController::class, 'reorder'])->name('reorder-links');
    Route::post('/reorder-stories/{entity}', [StoryController::class, 'reorder'])->name('reorder-stories');

    Route::middleware(UserIsAdmin::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/delete-user/{user}', [UserController::class, 'destroy'])->name('delete-user');
    });
});
