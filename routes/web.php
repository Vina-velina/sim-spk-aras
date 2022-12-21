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
// Redirect to Login
Route::get('/', function () {
    return redirect(route('login'));
});

// Route Auth
Auth::routes([
    'register' => false,
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

// General Page
Route::prefix('help')->group(function () {
    Route::get('/privacy-policy', [GeneralController::class, 'index'])->name('admin.general.privacy-policy');
    Route::get('/terms-conditions', [GeneralController::class, 'terms'])->name('admin.general.terms-conditions');
    Route::get('/sitemap.xml', [GeneralController::class, 'sitemap'])->name('admin.general.sitemaps');
});

// Route Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'verified', 'role:admin|super_admin']], function () {
    // Dashboard
    Route::prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    });

    // Master Data
    Route::group(['prefix' => 'master-data',  'middleware' => ['role:super_admin']], function () {
        // Data Debitur
        Route::prefix('debitur')->group(function () {
            Route::get('/', [DebiturController::class, 'index'])->name('admin.master-data.debitur.index');
            Route::get('/datatable', [DebiturController::class, 'datatable'])->name('admin.master-data.debitur.datatable');
            Route::get('/edit/{id}', [DebiturController::class, 'edit'])->name('admin.master-data.debitur.edit');
            Route::get('/detail/{id}', [DebiturController::class, 'detail'])->name('admin.master-data.debitur.detail');
            Route::get('/create', [DebiturController::class, 'create'])->name('admin.master-data.debitur.create');
            Route::patch('/update/{id}', [DebiturController::class, 'update'])->name('admin.master-data.debitur.update');
            Route::get('/update-status/{id}', [DebiturController::class, 'updateStatus'])->name('admin.master-data.debitur.update.status');
            Route::post('/store', [DebiturController::class, 'store'])->name('admin.master-data.debitur.store');
            Route::delete('/delete/{id}', [DebiturController::class, 'delete'])->name('admin.master-data.debitur.delete');
            Route::get('download-template-import', [DebiturController::class, 'downloadTemplate'])->name('admin.master-data.debitur.download-template');
            Route::post('import-debitur', [DebiturController::class, 'import'])->name('admin.master-data.debitur.import');
            Route::get('export-debitur', [DebiturController::class, 'export'])->name('admin.master-data.debitur.export');
        });
    });
});
