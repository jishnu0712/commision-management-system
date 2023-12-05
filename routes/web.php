<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    TransactionController,
    CreateUserController,
    DepartmentController,
    DashboardController,
    DoctorController,
    LogoutController,
    LoginController,
    PasswordController,
    ProfileController
};

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

    // PROFILR ROUTES
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // USER ROUTES 
    Route::get('/user', [CreateUserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [CreateUserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [CreateUserController::class, 'store'])->name('user.store');
    Route::post('/user/update', [CreateUserController::class, 'update'])->name('user.update');
    Route::get('/user/edit/{user_id}', [CreateUserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/permission', [CreateUserController::class, 'permission'])->name('user.permission');
    Route::post('/user/delete', [CreateUserController::class, 'delete'])->name('user.delete');
    Route::get('/user/download', [CreateUserController::class, 'download'])->name('user.download');

    // DEPARTMENTS ROUTES 
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::post('/department/update', [DepartmentController::class, 'update'])->name('department.update');
    Route::post('/department/delete', [DepartmentController::class, 'delete'])->name('department.delete');
    Route::get('/department/edit/{department_id}', [DepartmentController::class, 'edit'])->name('department.edit');

    // DOCTOR ROUTES 
    Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/doctor/store', [DoctorController::class, 'store'])->name('doctor.store');
    Route::post('/doctor/update', [DoctorController::class, 'update'])->name('doctor.update');
    Route::post('/doctor/delete', [DoctorController::class, 'delete'])->name('doctor.delete');
    Route::get('/doctor/edit/{doctor_id}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::post('/doctor/payment', [DoctorController::class, 'payment'])->name('doctor.payment');
    Route::get('/doctor/download', [DoctorController::class, 'download'])->name('doctor.download');

    // TRANSACTION ROUTES 
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::get('/transaction/invoice', [TransactionController::class, 'invoice'])->name('transaction.invoice');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/transaction/department', [TransactionController::class, 'department'])->name('transaction.department');
    Route::get('/transaction/view/{doctor_id}', [TransactionController::class, 'view'])->name('transaction.view');
    Route::get('/transaction/download', [TransactionController::class, 'download'])->name('transaction.download');
    Route::get('/transaction/edit', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::post('/transaction/update', [TransactionController::class, 'update'])->name('transaction.update');

    // PASSWORD ROUTE
    Route::get('/password', [PasswordController::class, 'index'])->name('password.index');
    Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');
});
