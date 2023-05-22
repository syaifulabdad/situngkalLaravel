<?php

use App\Http\Controllers\InputTppController;
use App\Http\Controllers\JenisTppController;
use App\Http\Controllers\PtkController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\TppPerbulanController;
use App\Http\Controllers\TugasPtkController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\LoginGoogle;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RekapTppController;
use App\Http\Controllers\User\ProfileContoller;
use App\Http\Controllers\User\UserContoller;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Basic Auth
Route::controller(Login::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login/proses', 'proses')->name('proses');
    Route::get('logout', 'logout')->name('logout');
});

// Google Auth
Route::get('authorized/google', [LoginGoogle::class, 'redirectToGoogle']);
Route::get('authorized/google/callback', [LoginGoogle::class, 'googleCallback']);

Route::prefix('wilayah')->group(function () {
    Route::get('/ajax-provinsi', [WilayahController::class, 'ajaxProvinsi'])->name('ajaxProvinsi');
    Route::get('/ajax-kabupaten', [WilayahController::class, 'ajaxKabupaten'])->name('ajaxKabupaten');
    Route::get('/ajax-kecamatan', [WilayahController::class, 'ajaxKecamatan'])->name('ajaxKecamatan');
    Route::get('/ajax-kelurahan', [WilayahController::class, 'ajaxKelurahan'])->name('ajaxKelurahan');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('/profile', ProfileContoller::class);
    Route::resource('/user', UserContoller::class);
    Route::resource('/admin', UserContoller::class)->middleware('isAdmin');
    Route::resource('/user-op', UserContoller::class)->middleware('isAdmin');
    Route::resource('/user-ops', UserContoller::class);
    Route::resource('/user-ptk', UserContoller::class)->middleware(['isOps']);


    Route::resource('/sekolah', SekolahController::class);
    Route::get('/ajax-sekolah', [SekolahController::class, 'ajaxSekolah'])->name('ajaxSekolah');
    Route::get('/sekolah-tarik-kemdikbud', [SekolahController::class, 'tarikDataKemdikbud'])->name('sekolah-tarikKemdikbud');
    Route::get('/sekolah-unduh-excel', [SekolahController::class, 'unduhExcel'])->name('sekolah-unduh-excel');
    Route::post('/sekolah-import-excel', [SekolahController::class, 'importExcel'])->name('sekolah-import-excel');
    Route::resource('/ptk', PtkController::class);
    Route::get('/ptk-unduh-excel', [PtkController::class, 'unduhExcel'])->name('ptk-unduh-excel');
    Route::post('/ptk-import-excel', [PtkController::class, 'importExcel'])->name('ptk-import-excel');
    Route::resource('/ptk-nonaktif', PtkController::class);
    Route::resource('/tugas-tambahan-ptk', TugasPtkController::class);
    Route::resource('/jenis-tpp', JenisTppController::class);
    Route::resource('/tpp-perbulan', TppPerbulanController::class);

    Route::get('/simpan-tpp', [InputTppController::class, 'store'])->name('simpan-tpp');
    Route::resource('/input-tpp', InputTppController::class);
    Route::resource('/rekap-tpp', RekapTppController::class);
    Route::get('/laporan-tpp-pdf', [RekapTppController::class, 'laporanPdf'])->name('laporan-tpp-pdf');
});
