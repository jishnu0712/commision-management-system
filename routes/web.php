<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// LOGIN CONTROLLER
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.login');
});
// LOGOUT CONTROLLER
Route::get('/logout', [LogoutController::class, 'index'])->name('logout');

// AFTER LOGIN CONTROLLER
Route::middleware(['auth'])->group(function () {
    // DASHBOARD ROUTE
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

});
