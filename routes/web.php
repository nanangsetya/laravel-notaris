<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\RiwayatPermohonanController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    if (!Auth::user()) {
        return redirect()->to('login');
    } else {
        return redirect()->to('dashboard');
    }
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'signin'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'check.role:1'], function () {
    Route::get('', [UserController::class, 'index'])->name('index');
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('update', [UserController::class, 'update'])->name('update');
    Route::get('activation', [UserController::class, 'activation'])->name('activation');
    Route::get('delete/{id}', [UserController::class, 'delete'])->name('delete');
});

Route::group(['middleware' => 'check.role:2,3'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'pemohon', 'as' => 'pemohon.'], function () {
        Route::get('/', [PemohonController::class, 'index'])->name('index');
        Route::get('datatable', [PemohonController::class, 'datatable'])->name('datatable');
        Route::get('dataAjax', [PemohonController::class, 'dataAjax'])->name('dataAjax');
        Route::get('create', [PemohonController::class, 'create'])->name('create');
        Route::post('store', [PemohonController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PemohonController::class, 'edit'])->name('edit');
        Route::post('update', [PemohonController::class, 'update'])->name('update');
        Route::get('delete/{nik}', [PemohonController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
        Route::get('/', [PermohonanController::class, 'index'])->name('index');
        Route::get('create', [PermohonanController::class, 'create'])->name('create');
        Route::post('store', [PermohonanController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PermohonanController::class, 'edit'])->name('edit');
        Route::post('update', [PermohonanController::class, 'update'])->name('update');
        Route::get('delete/{id}', [PermohonanController::class, 'delete'])->name('delete');
        Route::get('detail/{id}', [PermohonanController::class, 'detail'])->name('detail');
        Route::get('datatable', [PermohonanController::class, 'datatable'])->name('datatable');
        Route::get('export', [PermohonanController::class, 'export'])->name('export');
    });

    Route::group(['prefix' => 'riwayat', 'as' => 'riwayat.'], function () {
        Route::post('store', [RiwayatPermohonanController::class, 'store'])->name('store');
        Route::get('delete/{id}', [RiwayatPermohonanController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::post('store', [PembayaranController::class, 'store'])->name('store');
        Route::get('delete/{id}', [PembayaranController::class, 'delete'])->name('delete');
        Route::get('datatable', [PembayaranController::class, 'datatable'])->name('datatable');
        Route::get('export', [PembayaranController::class, 'export'])->name('export');
    });

    Route::get('download/{filename}', [PermohonanController::class, 'download_file'])->name('download');
});
