<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Redirect to Login
Route::get('/', function () {
    return redirect(route('login'));
});

// Route Auth
Auth::routes([
    'reset' => false,
]);

// Reset Password Module
Route::prefix('reset-password')->group(function () {
    Route::prefix('email')->group(function () {
        Route::get('/', [ForgotPasswordController::class, 'forgetPasswordEmailView'])->name('reset.password.email');
        Route::post('/aksi', [ForgotPasswordController::class, 'forgetPasswordStore'])->name('reset.password.aksi');
    });

    Route::prefix('change-password')->group(function () {
        Route::get('token/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password.getEmail');
        Route::post('aksi', [ForgotPasswordController::class, 'resetPasswordStore'])->name('reset.password.update');
    });
});

// Route Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'verified', 'role:admin|super_admin']], function () {
    Route::prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    });
});
