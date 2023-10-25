<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web'])->group(function () {
    // Ваши маршруты здесь

Route::get('/',[HotelController::class,'show'])->name('home');

Route::post('/hotels/search', [SearchController::class, 'search'])->name('hotels.search');


Route::get('/{hotel}/rooms', [RoomController::class, 'show'])->name('rooms.show');
Route::post('/{hotel}/rooms/search', [RoomController::class, 'search'])->name('rooms.search');

Route::get('/booking/show/{room}', [BookingController::class, 'show'])->name('booking.show');
Route::post('/booking/make', [BookingController::class, 'make'])->name('booking.make');


Route::get('/user/profile', [UserController::class, 'show'])->name('profile.show');

Auth::routes();

});
