<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AccountController;

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

Route::get('/login', [AuthUserController::class, 'getLoginPage'])->name('login');
Route::post('/login', [AuthUserController::class, 'login']);
Route::get('/sing-up', [AuthUserController::class, 'getSignUpPage'])->name('sing-up');
Route::post('/sing-up', [UserController::class, 'setNewUser']);
Route::get('/logout', [AuthUserController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'authUser'], function () {
    Route::get('/', [AuthUserController::class, 'getWelcomePage'])->name('welcome');

    Route::group(['prefix' => 'user'], function () {
        Route::get('{id}', [UserController::class, 'getUserPage'])->name('user');
        Route::post('{id}', [UserController::class, 'setUser']);
        Route::get('{id}/change-pass', [UserController::class, 'getChangePassPage'])->name('user-change-pass');
        Route::post('{id}/change-pass', [UserController::class, 'changePass']);
    });

    Route::group(['prefix' => 'accounts'], function () {
        Route::get('/', [AccountController::class, 'getAccounts'])->name('accounts');
        Route::post('/', [AccountController::class, 'setAccount']);
        Route::post('{id}/setStatus', [AccountController::class, 'setStatus'])->name('account-set-status');
    });
});

Route::get('/hola', [UserController::class, 'test']);

Route::fallback(function () {
    return response()->view('adm.404', [], 404);
});