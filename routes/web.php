<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Guest;
use App\Http\Middleware\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FacilityController;

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

// Route::get('/', [leafletController::class, 'index'])->name('index');
// Route::post('/', [leafletController::class, 'create'])->name('create');
// Route::post('/edit/{id}', [leafletController::class, 'edit'])->name('edit');
// Route::get('/edit/{id}/{lat}/{lng}', [leafletController::class, 'edit_location'])->name('edit-location');
// Route::get('/delete/{id}', [leafletController::class, 'delete'])->name('delete');

Route::middleware(['throttle:60,1'])->group(function() {
    Route::get('/', [HotelController::class, 'index'])->name('index');
    
    Route::middleware([Guest::class])->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
    });
    
    Route::middleware([User::class])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::post('/hotel', [HotelController::class, 'create'])->name('create-hotel');
        Route::put('/hotel/{id}', [HotelController::class, 'edit'])->name('edit-hotel');
        Route::patch('/hotel/{id}', [HotelController::class, 'edit_location'])->name('edit-hotel-location');
        Route::delete('/hotel/{id}', [HotelController::class, 'delete'])->name('delete-hotel');
        
        Route::post('/room/{id}', [RoomController::class, 'create'])->name('create-room');
        Route::put('/room/{id}/{hotel_id}', [RoomController::class, 'edit'])->name('edit-room');
        Route::delete('/room/{id}/{hotel_id}', [RoomController::class, 'delete'])->name('delete-room');
        
        Route::post('/facility/{id}', [FacilityController::class, 'create'])->name('create-facility');
        Route::put('/facility/{id}/{hotel_id}', [FacilityController::class, 'edit'])->name('edit-facility');
        Route::delete('/facility/{id}/{hotel_id}', [FacilityController::class, 'delete'])->name('delete-facility');
    });
});

