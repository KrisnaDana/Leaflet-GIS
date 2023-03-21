<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\leafletController;

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

Route::get('/', [leafletController::class, 'index'])->name('index');
Route::post('/', [leafletController::class, 'create'])->name('create');
Route::post('/edit/{id}', [leafletController::class, 'edit'])->name('edit');
Route::get('/edit/{id}/{lat}/{lng}', [leafletController::class, 'edit_location'])->name('edit-location');
Route::get('/delete/{id}', [leafletController::class, 'delete'])->name('delete');
