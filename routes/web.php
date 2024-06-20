<?php

use App\Http\Controllers\EntityController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserIsAdmin;
use App\Models\Entity;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'entities' => Entity::orderBy('area')->orderBy('district')->whereHas('users')->get()
    ]);
})->name('home');

Route::view('/privacy', 'privacy')->name('privacy');

Route::view('/login', 'login')->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::get('/logout', [UserController::class, 'logout']);

Route::get('/register', function () {
    return view('register', [
        'areas' => Entity::orderBy('area')->whereNotNull('area')->whereNull('district')->get()
    ]);
})->name('register');

Route::post('/register', [RegistrationController::class, 'store']);


# Authenticated Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/entity/{entityId?}', [EntityController::class, 'show'])->name('entity');
    Route::get('/create-story/{entityId?}', [StoryController::class, 'create'])->name('create-story');
    Route::post('/create-story/{entityId?}', [StoryController::class, 'store']);
    Route::get('/edit-story/{story}', [StoryController::class, 'edit'])->name('edit-story');
    Route::put('/edit-story/{story}', [StoryController::class, 'update']);
    Route::get('/delete-story/{story}', [StoryController::class, 'destroy'])->name('delete-story');
    Route::post('/reorder-stories/{entityId?}', [StoryController::class, 'reorder'])->name('reorder-stories');

    Route::middleware(UserIsAdmin::class)->group(function () {
        Route::resource('entities', EntityController::class);
        Route::resource('users', UserController::class);
        Route::get('/gso', [StoryController::class, 'gso'])->name('gso');
        Route::get('/delete-user/{user}', [UserController::class, 'destroy'])->name('delete-user');
    });
});


# Email Verification

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
