<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
use App\Models\Area;
use App\Models\District;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', [
        'districts' => District::with('area')->orderBy('area_id')->orderBy('number')->get()
    ]);
});

Route::view('/privacy', 'privacy');

Route::view('/login', 'login')->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::get('/logout', [UserController::class, 'logout']);

Route::view('/register', function () {
    return view('register', [
        'areas' => Area::orderBy('id')->get()
    ]);
});

Route::post('/register', [RegistrationController::class, 'store']);


# Authenticated Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/stories/{areaId}/{districtNumber}', [StoryController::class, 'index']);
    Route::get('/stories/{areaId}/{districtNumber}/create', [StoryController::class, 'create']);
    Route::post('/stories/{areaId}/{districtNumber}', [StoryController::class, 'store']);
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
