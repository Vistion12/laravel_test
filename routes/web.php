<?php

use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
// Public Routes
Route::get('/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/github/callback', function () {
    $socialUser = Socialite::driver('github')->user();
    //dd($socialUser);
    $user = User::query()->where('email', $socialUser->getEmail())->first();
    //dd($user);
    if (!$user) {
        $user = User::query()->create([
           'email' => $socialUser->getEmail(),
            'name' => $socialUser->getName(),
            'password'=>'password',
        ]);
    }
    Auth::login($user);
    return redirect('/');
});



Route::view('/', 'index')->name('home');

// Post Routes
Route::get('/posts/{post}', [PostController::class, 'show'])->where('post', '[0-9]+')->name('posts.show');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts/{id}/add/like', [PostController::class, 'addLike'])->name('posts.like.add');

// Category Routes
Route::get('/posts/categories/', [CategoryController::class, 'index'])->name('posts.categories.index');
Route::get('/posts/categories/{category}', [CategoryController::class, 'show'])->name('posts.categories.show');

// User Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->where('user', '[0-9]+')->name('users.show');

// Admin Routes
Route::name('admin.')
    ->middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [AdminIndexController::class, 'index'])->name('index');

        Route::resource('/users', AdminUserController::class);

        Route::post('/users/{id}/admin', [AdminUserController::class, 'addAdmin'])->name('add');

        Route::resource('/posts', AdminPostController::class)->except('show');

        Route::delete('/destroy/{post}', [AdminPostController::class, 'destroy'])->name('destroy');

        Route::get('/categories', [AdminIndexController::class, 'categories'])->name('categories');
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
