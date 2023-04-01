<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HotelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', [HotelController::class, 'api_url'])->name('api_url');
Route::get('/hotels', [HotelController::class, 'index']);
Route::post('/hotel', [HotelController::class, 'store']);
Route::patch('/hotel/{id}', [HotelController::class, 'update']);
Route::delete('/hotel/{id}', [HotelController::class, 'destroy']);