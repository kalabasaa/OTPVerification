<?php

use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OtpController::class, 'showRequestForm'])->name('otp.request');
Route::post('/otp/send', [OtpController::class, 'send'])->middleware('throttle:5,1')->name('otp.send');

Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/otp/verify', [OtpController::class, 'verify'])->middleware('throttle:10,1')->name('otp.verify');

Route::get('/home', [OtpController::class, 'home'])->name('home');
Route::post('/logout', [OtpController::class, 'logout'])->name('logout');