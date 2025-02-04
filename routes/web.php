<?php

use App\Http\Controllers\Admin\IndexController as AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Auth;
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
//restfull
Route::view('/', 'index')->name('home');

Route::name('posts.')
    ->prefix('posts')
    ->group(function () {
        Route::get('/{id}', [PostsController::class, 'show'])->where('id', '[0-9]+')->name('show');
        Route::get('/', [PostsController::class, 'index'])->name('index');
    });




Route::name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/users', [AdminController::class, 'posts'])->name('users');
        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    });




Auth::routes();

//Route::get('/home', [HomeController::class, 'index'])->name('home');
