<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Data\DataController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Cable\CableController;
use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Airtime\AirtimeController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Utility\UtilityController;
use App\Http\Controllers\Data\DataNetworkController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Network\FormatNumberController;
use App\Http\Controllers\Cable\VerifyCableUserController;
use App\Http\Controllers\Network\NetworkProviderController;
use App\Http\Controllers\Transaction\TransactionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function(){ 
    //Authentication
    Route::controller(AuthController::class)->group(function() {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout')->middleware('auth:sanctum');
    });
    
    Route::controller(VerificationController::class)->group(function() {
        Route::get('/email/verify/{id}/{hash}','__invoke')->name('verification.verify')->middleware(['signed']);
        Route::get('/verify/send/email', 'sendVerificationMail')->name('send.verification.mail')->middleware('auth:sanctum');
    });

    Route::controller(PasswordResetController::class)->group(function() {
        Route::post('/forgot-password', 'forgotPassword')->name('password.request');
        Route::get('/reset-password/{token}', 'resetPasswordToken')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
    });

    //Phone Number Services
    Route::post('/format-number', [FormatNumberController::class, 'index'])->name('format.number');
    Route::post('/network-provider', [NetworkProviderController::class, 'index'])->name('network.provider');

    Route::apiResource('airtimes', AirtimeController::class)->only(['store']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('data', DataController::class);
    Route::apiResource('cables', CableController::class);

    Route::post('data-network', [DataNetworkController::class, 'index'])->name('data.network');

    Route::post('verify-cable-user', [VerifyCableUserController::class, 'store'])->name('verify.cable.user');

    Route::apiResource('packages', PackageController::class);

    Route::get('/utilities', [UtilityController::class, 'index'])->name('utility');
    Route::get('/groups', [GroupController::class, 'index'])->name('group');

    Route::apiResource('/transactions', TransactionController::class)->only(['index', 'show']);

    Route::get('/payment-callback', [PaymentController::class, 'handleGatewayCallback'])->name('payment.callback');

    Route::apiResource('roles', RoleController::class);
});
