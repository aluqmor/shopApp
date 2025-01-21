<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [SaleController::class, 'index'])->name('sales.index');