<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\OwnersController;

// Route::get('/', function () {
//     return view('admin.welcome');
// });

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin'])->name('dashboard');

Route::resource('owners', OwnersController::class)
->middleware('auth:admin')->except(['show']);

Route::prefix('expired-owners')->middleware('auth:admin')->group(function () {
    Route::get('index', [OwnersController::class, 'expiredOwnerIndex'])->name('expired-owners.index');
    Route::post('destroy/{owner}', [OwnersController::class, 'expiredOwnerDestroy'])->name('expired-owners.destroy');
});

Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create']) //ユーザー登録画面
    //             ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']); //ユーザー登録処理

    Route::get('login', [AuthenticatedSessionController::class, 'create']) //ログイン画面
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']); //ログイン処理

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create']) //パスワードリセットリンク送信画面
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store']) //パスワードリセットリンク送信処理(email送信処理)
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create']) //パスワードリセット画面
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store']) //パスワードリセット処理
                ->name('password.update');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
