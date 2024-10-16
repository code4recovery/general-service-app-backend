<?php

use App\Http\Controllers\ButtonController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\MapImportController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserIsAdmin;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// set the app locale based on the user's preferred language
$lang = Request::getPreferredLanguage(['en', 'es', 'fr']);
if ($lang) {
    Config::set('app.locale', $lang);
}

Route::view('/', 'home')->name('home');

Route::view('/privacy', 'privacy')->name('privacy');

Route::get('/login', [UserController::class, 'login_form'])->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::get('/verify-login/{token}', [UserController::class, 'verifyLogin'])->name('verify-login');

Route::get('/logout', [UserController::class, 'logout']);

Route::view('/map', 'map')->name('map');

Route::view('/onboarding', 'onboarding')->name('onboarding');

# Authenticated Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('entities', EntityController::class);
    Route::resource('entities.stories', StoryController::class);
    Route::resource('entities.stories.buttons', ButtonController::class);

    Route::get('/delete-entity/{entity}', [EntityController::class, 'destroy'])->name('delete-entity');
    Route::get('/delete-story/{story}', [StoryController::class, 'destroy'])->name('delete-story');
    Route::get('/delete-button/{button}', [ButtonController::class, 'destroy'])->name('delete-button');

    Route::post('/reorder-buttons/{story}', [ButtonController::class, 'reorder'])->name('reorder-buttons');
    Route::post('/reorder-stories/{entity}', [StoryController::class, 'reorder'])->name('reorder-stories');

    Route::middleware(UserIsAdmin::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/delete-user/{user}', [UserController::class, 'destroy'])->name('delete-user');
    });

    Route::post('/users/add/{entity?}', [UserController::class, 'add'])->name('add-user');
    Route::get('/users/{user}/remove/{entity?}', [UserController::class, 'remove'])->name('remove-user');

    Route::get('/import', [MapImportController::class, 'index']);
    Route::get('/import/{area}', [MapImportController::class, 'import']);
});
