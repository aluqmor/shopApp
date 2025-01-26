<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Auth\ProfileController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Rutas de autenticación
Auth::routes(['verify' => true]);

// Ruta para usuarios verificados
Route::get('/verificado', function () { return view('auth.verified'); })->name('verificado');

// Rutas del perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/email', [ProfileController::class, 'changeEmail'])->name('profile.email');
    Route::post('/profile/username', [ProfileController::class, 'changeUsername'])->name('profile.username');
});

// Rutas de ventas
Route::post('/sales/{sale}/purchase', [SaleController::class, 'purchase'])
    ->name('sales.purchase')
    ->middleware('auth');

Route::get('/', [SaleController::class, 'index'])->name('sales.index');
Route::resource('sales', SaleController::class);
Route::resource('categories', CategoryController::class); 
Route::resource('settings', SettingController::class);
Route::resource('images', ImageController::class);