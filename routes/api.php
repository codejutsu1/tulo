<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Data\DataController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Cable\CableController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Airtime\AirtimeController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Data\DataNetworkController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Admin\Group\GroupController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\Role\RoleUserController;
use App\Http\Controllers\Admin\User\UserRoleController;
use App\Http\Controllers\Network\FormatNumberController;
use App\Http\Controllers\Admin\Group\GroupUserController;
use App\Http\Controllers\Admin\Utility\UtilityController;
use App\Http\Controllers\Cable\VerifyCableUserController;
use App\Http\Controllers\Admin\User\UserPackageController;
use App\Http\Controllers\Network\NetworkProviderController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Admin\Group\GroupPackageController;
use App\Http\Controllers\Admin\Group\GroupUtilityController;
use App\Http\Controllers\Admin\Package\PackageUserController;
use App\Http\Controllers\Admin\Package\PackageGroupController;
use App\Http\Controllers\Admin\User\UserTransactionController;
use App\Http\Controllers\Admin\Package\PackageUtilityController;
use App\Http\Controllers\Admin\Package\PackageTransactionController;
use App\Http\Controllers\Admin\Transaction\TransactionUserController;
use App\Http\Controllers\Admin\Transaction\TransactionPackageController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

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

    Route::apiResource('packages', PackageController::class);

    Route::middleware('auth:sanctum')->group(function() {
        //Admin
        Route::middleware('role:admin')->prefix('admin')->group(function() {
            Route::apiResource('roles', RoleController::class);
            Route::get('/utilities', [UtilityController::class, 'index'])->name('utility');
            Route::get('/groups', [GroupController::class, 'index'])->name('group');
            Route::apiResource('users', UserController::class);

            Route::apiResource('users.transactions', UserTransactionController::class)->only('index');
            Route::apiResource('users.roles', UserRoleController::class)->only('index');
            Route::apiResource('users.packages', UserPackageController::class)->only('index');

            Route::apiResource('transactions.users', TransactionUserController::class)->only('index');
            Route::apiResource('transactions.packages', TransactionPackageController::class)->only('index');

            Route::apiResource('packages.transactions', PackageTransactionController::class)->only('index');
            Route::apiResource('packages.users', PackageUserController::class)->only('index');
            Route::apiResource('packages.groups', PackageGroupController::class)->only('index');
            Route::apiResource('packages.utilities', PackageUtilityController::class)->only('index');

            Route::apiResource('roles.users', RoleUserController::class)->only('index');

            Route::apiResource('groups.users', GroupUserController::class)->only('index');
            Route::apiResource('groups.packages', GroupPackageController::class)->only('index');
            Route::apiResource('groups.utilities', GroupUtilityController::class)->only('index');
        });

        //Airtime
        Route::apiResource('airtimes', AirtimeController::class)->only(['store']);

        //Data
        Route::apiResource('data', DataController::class)->only(['index', 'store']);
        Route::post('data-network', [DataNetworkController::class, 'index'])->name('data.network');

        //Cable
        Route::apiResource('cables', CableController::class)->only(['index', 'store']);
        Route::post('verify-cable-user', [VerifyCableUserController::class, 'store'])->name('verify.cable.user');

        //Transactions
        Route::apiResource('/transactions', TransactionController::class)->only(['index', 'show']);
        Route::get('/payment-callback', [PaymentController::class, 'handleGatewayCallback'])->name('payment.callback');

        //User Profile
        Route::controller(UserProfileController::class)->group(function() {
            Route::get('/user', 'show')->name('user.profile');
            Route::put('/user', 'update')->name('user.update');
            Route::delete('/user', 'destroy')->name('user.delete');
        });
    });
});
