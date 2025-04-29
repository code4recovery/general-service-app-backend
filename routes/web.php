<?php

use App\Http\Controllers\ButtonController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapImportController;
use App\Http\Controllers\StoryController;
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

Route::get('/login', [LoginController::class, 'login_form'])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/verify-login/{token}', [LoginController::class, 'verifyLogin'])->name('verify-login');

Route::get('/logout', [LoginController::class, 'logout']);

Route::view('/map', 'map')->name('map');

Route::view('/get-started', 'get-started')->name('get-started');

Route::get('/api/coverage', [EntityController::class, 'coverage']);

Route::prefix('/download')->group(function () {
    Route::view('/', 'download');
    Route::redirect('/ios', 'https://apps.apple.com/us/app/general-service/id6670377389', 301);
    Route::redirect('/android', 'https://play.google.com/store/apps/details?id=app.generalservice', 301);
});

# Authenticated Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('entities', EntityController::class);
    Route::resource('entities.stories', StoryController::class);
    Route::get('/entities/{entity}/districts', [EntityController::class, 'districts'])->name('districts');
    Route::resource('entities.stories.buttons', ButtonController::class);

    Route::get('/delete-entity/{entity}', [EntityController::class, 'destroy'])->name('delete-entity');
    Route::get('/delete-story/{story}', [StoryController::class, 'destroy'])->name('delete-story');
    Route::get('/delete-button/{button}', [ButtonController::class, 'destroy'])->name('delete-button');

    Route::post('/reorder-buttons/{story}', [ButtonController::class, 'reorder'])->name('reorder-buttons');
    Route::post('/reorder-stories/{entity}', [StoryController::class, 'reorder'])->name('reorder-stories');

    Route::get('/import', [MapImportController::class, 'index']);
    Route::get('/import/{area}', [MapImportController::class, 'import']);
});
