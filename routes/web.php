<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('pengajuan.index');
});

Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
Route::patch('/pengajuan/{pengajuan}/status/{status}', [PengajuanController::class, 'updateStatus'])
    ->name('pengajuan.update-status');

Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'detail'])->name('pengajuan.detail');
Route::put('/pengajuan/{pengajuan}', [PengajuanController::class, 'update'])->name('pengajuan.update');
Route::delete('/pengajuan/{pengajuan}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');

Route::get('/customer/search', [CustomerController::class, 'search'])->name('customer.search');
