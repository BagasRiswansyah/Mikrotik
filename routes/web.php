<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\EthernetController;
use App\Http\Controllers\AddressListController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/konfigurasi', [KonfigurasiController::class, 'index'])->name('konfigurasi.index');
    Route::post('/konfigurasi-simpan', [KonfigurasiController::class, 'store'])->name('konfigurasi.store');
    Route::get('/konfigurasi/{konfigurasi}/edit', [KonfigurasiController::class, 'edit'])->name('konfigurasi.edit');
    Route::put('/konfigurasi/{konfigurasi}', [KonfigurasiController::class, 'update'])->name('konfigurasi.update');
    Route::delete('/konfigurasi/{konfigurasi}', [KonfigurasiController::class, 'destroy'])->name('konfigurasi.destroy');
    Route::get('/ethernet', [EthernetController::class, 'index'])->name('ethernet.index');
    Route::post('/ethernet', [EthernetController::class, 'store'])->name('ethernet.store');
    Route::put('/ethernet/{ethernet}', [EthernetController::class, 'update'])->name('ethernet.update');
    Route::post('/ethernet/toggle/{id}', [App\Http\Controllers\EthernetController::class, 'toggle'])->name('ethernet.toggle');
    Route::post('/ethernet/toggle/{id}', [EthernetController::class, 'toggle'])->name('ethernet.toggle');
    Route::get('/addresslist', [AddressListController::class, 'index'])->name('addresslist.index');
    Route::post('/addresslist/toggle/{id}', [AddressListController::class, 'toggle'])->name('addresslist.toggle');
    Route::get('/addresslist', [AddressListController::class, 'index'])->name('addresslist.index');
    Route::post('/addresslist/store', [AddressListController::class, 'store'])->name('addresslist.store');
    Route::patch('/addresslist/{id}/disable', [AddressListController::class, 'disable'])->name('addresslist.disable');
    Route::patch('/addresslist/{id}/enable', [AddressListController::class, 'enable'])->name('addresslist.enable');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});


