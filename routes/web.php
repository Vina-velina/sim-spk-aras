<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DebiturController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\UserController;
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

        // Data User
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.master-data.user.index');
            Route::get('/create', [UserController::class, 'create'])->name('admin.master-data.user.create');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.master-data.user.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.master-data.user.update');
            Route::post('/store', [UserController::class, 'store'])->name('admin.master-data.user.store');
            Route::delete('/delete', [UserController::class, 'delete'])->name('admin.master-data.user.delete');
            Route::get('/datatable', [UserController::class, 'datatable'])->name('admin.master-data.user.datatable');
        });

        // Data Periode
        Route::prefix('periode')->group(function () {
            Route::get('/', [PeriodeController::class, 'index'])->name('admin.master-data.periode.index');
            Route::get('/detail/{id}', [PeriodeController::class, 'detail'])->name('admin.master-data.periode.detail');
            Route::get('/create', [PeriodeController::class, 'create'])->name('admin.master-data.periode.create');
            Route::get('/edit/{id}', [PeriodeController::class, 'edit'])->name('admin.master-data.periode.edit');
            Route::get('update-status/{id}', [PeriodeController::class, 'updateStatus'])->name('admin.master-data.periode.update.status');
            Route::post('/store', [PeriodeController::class, 'store'])->name('admin.master-data.periode.store');
            Route::post('/update/{periode:id}', [PeriodeController::class, 'update'])->name('admin.master-data.periode.update');
            Route::delete('/delete/{periode:id}', [PeriodeController::class, 'delete'])->name('admin.master-data.periode.delete');
            Route::get('/datatable', [PeriodeController::class, 'datatable'])->name('admin.master-data.periode.datatable');
        });

        // Data Kriteria
        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('admin.master-data.kategori.index');
            Route::get('/create', [KategoriController::class, 'create'])->name('admin.master-data.kategori.create');
            Route::get('/update-status/{kriteria_penilaian:id}', [KategoriController::class, 'updateStatus'])->name('admin.master-data.kategori.update.status');
            Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('admin.master-data.kategori.edit');
            Route::post('/store', [KategoriController::class, 'store'])->name('admin.master-data.kategori.store');
            Route::post('/update/{kriteria_penilaian:id}', [KategoriController::class, 'update'])->name('admin.master-data.kategori.update');
            Route::delete('/delete/{kriteria_penilaian:id}', [KategoriController::class, 'delete'])->name('admin.master-data.kategori.delete');
            Route::get('/datatable', [KategoriController::class, 'datatable'])->name('admin.master-data.kategori.datatable');

            // sub Kriteria
            Route::prefix('/sub-kriteria')->group(function () {
                Route::get('/create/{kriteria_penilaian:id}', [KategoriController::class, 'subCreate'])->name('admin.master-data.sub-kategori.create');
                Route::post('/store/{kriteria_penilaian:id}', [KategoriController::class, 'subStore'])->name('admin.master-data.sub-kategori.store');
                Route::get('/edit/{sub_kriteria_penilaian:id}', [KategoriController::class, 'subEdit'])->name('admin.master-data.sub-kategori.edit');
                Route::post('/update/{sub_kriteria_penilaian:id}', [KategoriController::class, 'subUpdate'])->name('admin.master-data.sub-kategori.update');
                Route::delete('/delete/{sub_kriteria_penilaian:id}', [KategoriController::class, 'subDelete'])->name('admin.master-data.sub-kategori.delete');
                Route::get('/sub_datatable/{kriteria_penilaian:id}', [KategoriController::class, 'sub_datatable'])->name('admin.master-data.kategori.sub-datatable');
            });
        });
    });

    // Account
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('admin.account.index');
        Route::post('/update', [AccountController::class, 'update'])->name('admin.account.update');
        Route::get('/change-password', [AccountController::class, 'editPassword'])->name('admin.account.change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('admin.account.update-password');
    });
});
