<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use App\Http\Controllers\ListingController;

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
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth')->name('create');
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth')->name('listings.manage');

Route::get('/', [ListingController::class, 'index'])->name('index');

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('show');
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware(['auth', 'isOwner'])->name('edit');
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware(['auth', 'isOwner'])->name('update');
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware(['auth', 'isOwner'])->name('delete');

Route::post('/listings', [ListingController::class, 'store'])->middleware('auth')->name('store');

Route::get('/register', [UserController::class, 'create'])->middleware('guest')->name('user.register');
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('user.login');
Route::get('/users/authenticate', [UserController::class, 'authenticate'])->name('user.authenticate');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('user.logout');
Route::post('/users', [UserController::class, 'store'])->name('user.store');


