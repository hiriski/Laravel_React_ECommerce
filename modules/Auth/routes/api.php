<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------                
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login-check-username', [AuthController::class, 'checkUsername']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/send-reset-password-link', [AuthController::class, 'sendResetPasswordLink']);
    Route::post('/password-reset/verify', [AuthController::class, 'verifyTokenPasswordReset']);
    Route::post('/password-reset', [AuthController::class, 'resetPassword']);
    Route::post('/revoke-token', [AuthController::class, 'revokeToken']);
    Route::get('/user', [AuthController::class, 'getAuthenticatedUser']);
    Route::post('/google/mobile', [AuthController::class, 'googleSignInMobile']);
});
