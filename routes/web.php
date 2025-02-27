<?php

use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Auth\GitHubController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

// публичные роуты


Route::view('/', 'index')->name('home');

// роуты авторизации через гитхаб
Route::get('/github/redirect', [GitHubController::class, 'redirectToGitHub'])->name('github.redirect');
Route::get('/github/callback', [GitHubController::class, 'handleGitHubCallback'])->name('github.callback');

// роуты публичных постов
Route::prefix('posts')
    ->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/{post}', [PostController::class, 'show'])->where('post', '[0-9]+')->name('posts.show');
        Route::post('/{id}/add/like', [PostController::class, 'addLike'])->name('posts.like.add');
        Route::get('/search', [PostController::class, 'search'])->name('posts.search');
});

// роуты публичных категорий
Route::prefix('categories')
    ->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show');
});

// роуты публичных юзеров
Route::prefix('users')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{user}', [UserController::class, 'show'])->where('user', '[0-9]+')->name('users.show');
});


// роуты коментов только авторизованых пользователей
Route::middleware('auth')
    ->group(function () {
        Route::name('comments.')
            ->prefix('comments')
            ->group(function () {
                Route::post('/posts/{post}', [CommentController::class, 'store'])->name('store');
                Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
                Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
                Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
    });
});

// админовские роуты
Route::name('admin.')
    ->middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->group(function () {
        // админовская панель
        Route::get('/', [AdminIndexController::class, 'index'])->name('index');

        // администрирование юзеров
        Route::prefix('users')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('users.index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('users.create');
            Route::post('/store', [AdminUserController::class, 'store'])->name('users.store');
            Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('users.update');
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
            Route::post('/{id}/admin', [AdminUserController::class, 'addAdmin'])->name('users.addAdmin');
        });

        // администрирование постов
        Route::prefix('posts')->group(function () {
            Route::get('/', [AdminPostController::class, 'index'])->name('posts.index');
            Route::get('/create', [AdminPostController::class, 'create'])->name('posts.create');
            Route::post('/store', [AdminPostController::class, 'store'])->name('posts.store');
            Route::get('/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
            Route::put('/{post}', [AdminPostController::class, 'update'])->name('posts.update');
            Route::delete('/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
        });

        // администрирование категорий
        Route::prefix('categories')->group(function () {
            Route::get('/', [AdminCategoryController::class, 'index'])->name('categories.index');
            Route::get('/create', [AdminCategoryController::class, 'create'])->name('categories.create');
            Route::post('/store', [AdminCategoryController::class, 'store'])->name('categories.store');
            Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
        });
    });


Auth::routes();





/*
              Route::name('posts.')
                    ->prefix('posts')
                    ->group(function () {

                        Route::get('/', [AdminPostController::class, 'index'])->name('index');
                        Route::get('/create', [AdminPostController::class, 'create'])->name('create');
                        Route::post('/store', [AdminPostController::class, 'store'])->name('store');
                        Route::get('/{post}/edit/', [AdminPostController::class, 'edit'])->name('edit');
                        Route::put('/update/{post}', [AdminPostController::class, 'update'])->name('update');
                        Route::delete('/destroy/{post}', [AdminPostController::class, 'destroy'])->name('destroy');
                    });*/
//Route::get('/home', [HomeController::class, 'index'])->name('home');
