<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
Route::patch('/pengajuan/{pengajuan}/status/{status}', [PengajuanController::class, 'updateStatus'])
    ->name('pengajuan.update-status');

Route::get('/customer/search', [CustomerController::class, 'search'])->name('customer.search');