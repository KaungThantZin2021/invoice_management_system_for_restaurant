<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\Admin\DashboardController;
use App\Http\Controllers\Backend\Admin\Auth\AuthenticatedSessionController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('backend.index');
//     // return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';


Route::prefix('/admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
                    ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
                    ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                    ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                    ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                    ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
                    ->name('password.store');
    });

    Route::get('/', [DashboardController::class, 'index']);
});
