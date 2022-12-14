<?php

use App\Http\Controllers\Admin\DebiturController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\General\GeneralController;
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
# Redirect to Login
Route::get('/', function () {
    return redirect(route('login'));
});

# Route Auth
Auth::routes([
    'register' => false,
    'reset' => false,
]);

# Reset Password Module
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

# General Page
Route::prefix('help')->group(function () {
    Route::get('/privacy-policy', [GeneralController::class, 'index'])->name('admin.general.privacy-policy');
    Route::get('/terms-conditions', [GeneralController::class, 'terms'])->name('admin.general.terms-conditions');
    Route::get('/sitemap.xml', [GeneralController::class, 'sitemap'])->name('admin.general.sitemaps');
});

# Route Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'verified', 'role:admin|super_admin']], function () {

    # Dashboard
    Route::prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    });

    # Master Data
    Route::group(['prefix' => 'master-data',  'middleware' => ['role:super_admin']], function () {

        # Data Debitur
        Route::prefix('debitur')->group(function () {
            Route::get('/', [DebiturController::class, 'index'])->name('admin.master-data.debitur.index');
        });
    });
});
