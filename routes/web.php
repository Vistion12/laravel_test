<?php

use App\Http\Controllers\Admin\IndexController as AdminController;
use App\Http\Controllers\PostsController;
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

Route::view('/','index')->name('home');
Route::get('/post/{id}', [PostsController::class,'show'])->name('post');
Route::get('/posts',[PostsController::class,'index'])->name('posts');

Route::name('admin. ')
    ->prefix('admin')
    ->group(function(){
        Route::get('/',[AdminController::class, 'index'])->name('index');
        Route::get('/users', [AdminController::class, 'posts'])->name('posts');
        Route::get('/posts',[AdminController::class, 'posts'])->name('posts');
        Route::get('/categories',[AdminController::class, 'categories'])->name('categories');
    });

