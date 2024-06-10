<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserIsAdmin;
use App\Models\Area;
use App\Models\District;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'districts' => District::with('area')->orderBy('area_id')->orderBy('number')->get()
    ]);
})->name('home');

Route::view('/privacy', 'privacy')->name('privacy');

Route::view('/login', 'login')->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::get('/logout', [UserController::class, 'logout']);

Route::get('/register', function () {
    return view('register', [
        'areas' => Area::orderBy('id')->get()
    ]);
})->name('register');

Route::post('/register', [RegistrationController::class, 'store']);


# Authenticated Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/district/{areaId}/{districtNumber}', [StoryController::class, 'district'])->name('district');
    Route::get('/create-story/{areaId}/{districtNumber}', [StoryController::class, 'create'])->name('create-story');
    Route::post('/create-story/{areaId}/{districtNumber}', [StoryController::class, 'store']);
    Route::get('/edit-story/{story}', [StoryController::class, 'edit'])->name('edit-story');
    Route::put('/edit-story/{story}', [StoryController::class, 'update']);
    Route::get('/delete-story/{story}', [StoryController::class, 'destroy'])->name('delete-story');

    Route::middleware(UserIsAdmin::class)->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/areas', [StoryController::class, 'areas'])->name('areas');
        Route::get('/area/{areaId}', [StoryController::class, 'area'])->name('area');
        Route::get('/districts', [StoryController::class, 'districts'])->name('districts');
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
