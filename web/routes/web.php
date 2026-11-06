<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Pages\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/informacion', [PagesController::class, 'more_about'])->name('more-about');
Route::get('/privacidad', [PagesController::class, 'privacy'])->name('privacy');
Route::get('/terminos', [PagesController::class, 'terms'])->name('terms');

Route::post('/user', [IndexController::class, 'storeEarlyUser'])->name('storeEarlyUser');
Route::post('/lead', [IndexController::class, 'storeLead'])->name('storeLead');