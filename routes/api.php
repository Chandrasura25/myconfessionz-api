<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthCounselorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/register', function (Request $request) {
    return $request->user();
});
// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password-reset-request', [AuthController::class, 'passwordResetRequest']);
Route::post('/password-recovery-answer', [AuthController::class, 'passwordRecoveryAnswer']);
Route::post('/reset-password', [AuthController::class, 'passwordReset']);

// Private Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
});

// COUNSELLORS

// Public Routes
Route::post('/register-counselor', [AuthCounselorController::class, 'registerCounselor']);
Route::post('/login-counselor', [AuthCounselorController::class, 'loginCounselor']);
Route::post('/counselor-password-reset-request', [AuthCounselorController::class, 'counselorPasswordResetRequest']);
Route::post('/counselor-password-recovery-answer', [AuthCounselorController::class, 'counselorPasswordRecoveryAnswer']);
Route::post('/counselor-reset-password', [AuthCounselorController::class, 'counselorPasswordReset']);

// Private Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout-counselor', [AuthCounselorController::class, 'logoutCounselor']);
});
