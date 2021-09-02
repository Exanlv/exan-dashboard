<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', [AuthController::class, 'home'])->name('home');

Route::get('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('auth/cb', [AuthController::class, 'callback'])->name('auth.callback');
