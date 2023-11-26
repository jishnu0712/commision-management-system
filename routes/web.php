<?php

use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Models\Doctor;

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

    // USER ROUTES 
    Route::get('/user', [CreateUserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [CreateUserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [CreateUserController::class, 'store'])->name('user.store');
    Route::post('/user/update', [CreateUserController::class, 'update'])->name('user.update');
    Route::get('/user/edit/{user_id}', [CreateUserController::class, 'edit'])->name('user.edit');

    // DEPARTMENTS ROUTES 
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::post('/department/update', [DepartmentController::class, 'update'])->name('department.update');
    Route::get('/department/edit/{department_id}', [DepartmentController::class, 'edit'])->name('department.edit');

    // DOCTOR ROUTES 
    Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/doctor/store', [DoctorController::class, 'store'])->name('doctor.store');
    Route::post('/doctor/update', [DoctorController::class, 'update'])->name('doctor.update');
    Route::get('/doctor/edit/{doctor_id}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::get('/doctor/sync/{doctor_id}', [DoctorController::class, 'sync'])->name('doctor.sync');

});
