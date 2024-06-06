<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use App\Models\Area;
use App\Models\District;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $districts = District::with('area')->get();
    return view('home', ['districts' => $districts]);
});

Route::view('/privacy', 'privacy');

Route::view('/login', 'login')->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::get('/logout', [UserController::class, 'logout']);

Route::get('/register', function () {
    $areas = Area::all();
    return view('register', ['areas' => $areas]);
});

Route::post('/register', [RegistrationController::class, 'store']);


# Authenticated Routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/district/{areaId}/{districtNumber}', function () {
        $user = auth()->user()->with('districts', 'districts.stories', 'districts.area')->first();
        $district = $user->districts->where(function ($district) {
            return $district->area_id == request('areaId') && $district->number == request('districtNumber');
        })->first();

        if (!$district) {
            return redirect('/');
        }

        return view('district', ['district' => $district]);
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
