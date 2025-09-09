<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', [ItemController::class, 'dashboard'])->name('dashboard');
Route::resource('items', ItemController::class);