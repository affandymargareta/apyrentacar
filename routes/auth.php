<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Auth\AdminConfirmablePasswordController;
use App\Http\Controllers\Auth\AdminEmailVerificationNotificationController;
use App\Http\Controllers\Auth\AdminEmailVerificationPromptController;
use App\Http\Controllers\Auth\AdminNewPasswordController;
use App\Http\Controllers\Auth\AdminPasswordController;
use App\Http\Controllers\Auth\AdminPasswordResetLinkController;
use App\Http\Controllers\Auth\AdminRegisteredUserController;
use App\Http\Controllers\Auth\AdminVerifyEmailController;

use App\Http\Controllers\Auth\SellerAuthenticatedSessionController;
use App\Http\Controllers\Auth\SellerConfirmablePasswordController;
use App\Http\Controllers\Auth\SellerEmailVerificationNotificationController;
use App\Http\Controllers\Auth\SellerEmailVerificationPromptController;
use App\Http\Controllers\Auth\SellerNewPasswordController;
use App\Http\Controllers\Auth\SellerPasswordController;
use App\Http\Controllers\Auth\SellerPasswordResetLinkController;
use App\Http\Controllers\Auth\SellerRegisteredUserController;
use App\Http\Controllers\Auth\SellerVerifyEmailController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|                            User Area
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth:web')->group(function () {

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

/*
|--------------------------------------------------------------------------
|                            User Area
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
|                            Seller Area
|--------------------------------------------------------------------------
*/

Route::middleware('guest:seller')->group(function () {
    // Route::get('/members/register', [SellerRegisteredUserController::class, 'create'])
    //             ->name('members.register');

    Route::post('/mregister', [SellerRegisteredUserController::class, 'store'])->name('mregister.store');

    Route::get('/members/login', [SellerAuthenticatedSessionController::class, 'create'])
                ->name('members.login');

    Route::post('/mlogin', [SellerAuthenticatedSessionController::class, 'store'])->name('mlogin.store');

    Route::get('/members/forgot-password', [SellerPasswordResetLinkController::class, 'create'])
                ->name('members.password.request');

    Route::post('/members/forgot-password', [SellerPasswordResetLinkController::class, 'store'])
                ->name('members.password.email');

    Route::get('/members/reset-password/{token}/{email}', [SellerNewPasswordController::class, 'create'])
                ->name('members.password.reset');

    Route::post('/members/reset-password', [SellerNewPasswordController::class, 'store'])
                ->name('members.password.store');
});

Route::middleware('auth:seller')->group(function () {
    Route::get('/members/verify-email', SellerEmailVerificationPromptController::class)
                ->name('members.verification.notice');

    Route::get('/members/verify-email/{id}/{hash}', SellerVerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('members.verification.verify');

    Route::post('/members/email/verification-notification', [SellerEmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('members.verification.send');

    Route::get('/members/confirm-password', [SellerConfirmablePasswordController::class, 'show'])
                ->name('members.password.confirm');

    Route::post('/members/confirm-password', [SellerConfirmablePasswordController::class, 'store']);

    Route::put('/members/password', [SellerPasswordController::class, 'update'])->name('members.password.update');

    Route::post('/mlogout', [SellerAuthenticatedSessionController::class, 'destroy'])
                ->name('mlogout.destroy');
});

 
/*
|--------------------------------------------------------------------------
|                            Seller Area
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
|                            Admin Area
|--------------------------------------------------------------------------
*/

Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/register', [AdminRegisteredUserController::class, 'create'])
                ->name('admin.register');

    Route::post('/admin/register', [AdminRegisteredUserController::class, 'store']);

    Route::get('/admin/login', [AdminAuthenticatedSessionController::class, 'create'])
                ->name('admin.login');

    Route::post('/admin/login', [AdminAuthenticatedSessionController::class, 'store']);

    Route::get('/admin/forgot-password', [AdminPasswordResetLinkController::class, 'create'])
                ->name('admin.password.request');

    Route::post('/admin/forgot-password', [AdminPasswordResetLinkController::class, 'store'])
                ->name('admin.password.email');
    
    Route::get('/admin/reset-password/{token}/{email}', [AdminNewPasswordController::class, 'create'])
        ->name('admin.password.reset');

    Route::post('/admin/reset-password', [AdminNewPasswordController::class, 'store'])
                ->name('admin.password.store');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/verify-email', AdminEmailVerificationPromptController::class)
                ->name('admin.verification.notice');

    Route::get('/admin/verify-email/{id}/{hash}', AdminVerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('admin.verification.verify');

    Route::post('/admin/email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('admin.verification.send');

    Route::get('/admin/confirm-password', [AdminConfirmablePasswordController::class, 'show'])
                ->name('admin.password.confirm');

    Route::post('/admin/confirm-password', [AdminConfirmablePasswordController::class, 'store']);

    Route::put('/admin/password', [AdminPasswordController::class, 'update'])->name('admin.password.update');

    Route::post('/alogout', [AdminAuthenticatedSessionController::class, 'destroy'])
                ->name('alogout.destroy');
});


/*
|--------------------------------------------------------------------------
|                            Admin Area
|--------------------------------------------------------------------------
*/