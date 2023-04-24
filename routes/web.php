<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DebiturController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\MasterKriteriaController;
use App\Http\Controllers\Admin\PenilaianController;
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
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.master-data.user.delete');
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
            Route::post('/update/{id}', [PeriodeController::class, 'update'])->name('admin.master-data.periode.update');
            Route::delete('/delete/{id}', [PeriodeController::class, 'delete'])->name('admin.master-data.periode.delete');
            Route::get('/datatable', [PeriodeController::class, 'datatable'])->name('admin.master-data.periode.datatable');
        });

        // Data Master Kriteria
        Route::prefix('master-kriteria')->group(function () {
            Route::get('/', [MasterKriteriaController::class, 'index'])->name('admin.master-data.master-kriteria.index');
            Route::get('/detail/{id}', [MasterKriteriaController::class, 'detail'])->name('admin.master-data.master-kriteria.detail');
            Route::get('/create', [MasterKriteriaController::class, 'create'])->name('admin.master-data.master-kriteria.create');
            Route::post('/store', [MasterKriteriaController::class, 'store'])->name('admin.master-data.master-kriteria.store');
            Route::get('/edit/{id}', [MasterKriteriaController::class, 'edit'])->name('admin.master-data.master-kriteria.edit');
            Route::post('/update/{id}', [MasterKriteriaController::class, 'update'])->name('admin.master-data.master-kriteria.update');
            Route::delete('/delete/{id}', [MasterKriteriaController::class, 'delete'])->name('admin.master-data.master-kriteria.delete');
            Route::get('/datatable', [MasterKriteriaController::class, 'datatable'])->name('admin.master-data.master-kriteria.datatable');
        });

        // Data Kriteria
        Route::prefix('kriteria-periode')->group(function () {
            Route::get('/', [KriteriaController::class, 'index'])->name('admin.master-data.kriteria.index');
            Route::get('/datatable-periode', [KriteriaController::class, 'periodeDataTable'])->name('admin.master-data.kriteria.datatable.periode');

            // Kriteria
            Route::group(['prefix' => 'kriteria', 'middleware' => 'allowActivePeriode'], function () {
                Route::prefix('{id_periode}')->group(function () {
                    Route::get('/', [KriteriaController::class, 'kriteria'])->name('admin.master-data.kriteria.kriteria');
                    Route::get('/create', [KriteriaController::class, 'create'])->name('admin.master-data.kriteria.create');
                    Route::get('/edit/{id_kriteria}', [KriteriaController::class, 'edit'])->name('admin.master-data.kriteria.edit');
                    Route::get('/update-status/{id_kriteria}', [KriteriaController::class, 'updateStatus'])->name('admin.master-data.kriteria.update.status');
                    Route::post('/store', [KriteriaController::class, 'store'])->name('admin.master-data.kriteria.store');
                    Route::post('/update/{id_kriteria}', [KriteriaController::class, 'update'])->name('admin.master-data.kriteria.update');
                    Route::delete('/delete/{id_kriteria}', [KriteriaController::class, 'delete'])->name('admin.master-data.kriteria.delete');
                    Route::get('/datatable/kriteria-penilaian', [KriteriaController::class, 'datatable'])->name('admin.master-data.kriteria.datatable');
                });
            });

            // sub Kriteria
            Route::group(['prefix' => 'sub-kriteria', 'middleware' => 'allowActivePeriode'], function () {
                Route::prefix('{id_periode}')->group(function () {
                    Route::get('/create/{id_kriteria}', [KriteriaController::class, 'subCreate'])->name('admin.master-data.sub-kriteria.create');
                    Route::post('/store/{id_kriteria}', [KriteriaController::class, 'subStore'])->name('admin.master-data.sub-kriteria.store');
                    Route::get('/edit/{id_kriteria}/{id_sub_kriteria}', [KriteriaController::class, 'subEdit'])->name('admin.master-data.sub-kriteria.edit');
                    Route::post('/update/{id_kriteria}/{id_sub_kriteria}', [KriteriaController::class, 'subUpdate'])->name('admin.master-data.sub-kriteria.update');
                    Route::delete('/delete/{id_kriteria}/{id_sub_kriteria}', [KriteriaController::class, 'subDelete'])->name('admin.master-data.sub-kriteria.delete');
                    Route::get('/sub_datatable', [KriteriaController::class, 'sub_datatable'])->name('admin.master-data.kriteria.sub-datatable');
                });
            });
        });
    });

    // Data Penilaian
    Route::prefix('data-penilaian')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('admin.penilaian.index');

        // Detail Periode
        Route::group(['prefix' => 'periode', 'middleware' => ['allowActivePeriode', 'allowByBobot']], function () {
            // Middleware Allow Active Periode hanya bisa aktif ketika ada param id_periode, sehingga wajib diisi
            Route::prefix('{id_periode}')->group(function () {
                Route::get('/', [PenilaianController::class, 'detail'])->name('admin.penilaian.detail-penilaian');
                Route::prefix('penilaian')->group(function () {
                    Route::get('/{id_debitur}', [PenilaianController::class, 'createOrEditPenilaian'])->name('admin.penilaian.detail-penilaian.add-penilaian');
                    Route::post('/{id_debitur}', [PenilaianController::class, 'storeOrUpdatePenilaian'])->name('admin.penilaian.detail-penilaian.store-penilaian');
                });
            });

            // Route::get('/detail/{id}', [PeriodeController::class, 'detail'])->name('admin.penilaian.detail');
            // Route::get('/create', [PeriodeController::class, 'create'])->name('admin.penilaian.create');
            // Route::get('/edit/{id}', [PeriodeController::class, 'edit'])->name('admin.penilaian.edit');
            // Route::get('update-status/{id}', [PeriodeController::class, 'updateStatus'])->name('admin.penilaian.update.status');
            // Route::post('/store', [PeriodeController::class, 'store'])->name('admin.penilaian.store');
            // Route::post('/update/{periode:id}', [PeriodeController::class, 'update'])->name('admin.penilaian.update');
            // Route::delete('/delete/{periode:id}', [PeriodeController::class, 'delete'])->name('admin.penilaian.delete');
        });
    });

    // Account
    Route::prefix('account')->group(function () {
        Route::get('/change-profil', [AccountController::class, 'editProfil'])->name('admin.account.index');
        Route::post('/update-profil', [AccountController::class, 'updateProfil'])->name('admin.account.update');
        Route::get('/change-password', [AccountController::class, 'editPassword'])->name('admin.account.change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('admin.account.update-password');
    });
});
