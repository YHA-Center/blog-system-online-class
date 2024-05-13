<?php

use App\Http\Middleware\UserAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('user.home');
});

// login

Route::middleware(['isLogin'])->group(function() { // check login middleware
    # Category Controller session
    Route::get('/category', [CategoryController::class, 'index'])->name('category.home');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/delete/{id}', [CategoryController::class, 'destory'])->name('category.delete');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    // post
    Route::get('/post', [PostController::class, 'index'])->name('post.list');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/destroy/{id}', [PostController::class, 'destroy'])->name('post.delete');
    Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::get('/post/get/{id}', [PostController::class, 'get'])->name('post.get');
    // profile
    Route::get('/profile', [HomeController::class, 'profile'])->name('user.profile'); // profile page
    Route::post('/profile/update', [HomeController::class, 'update'])->name('user.update');
});

// user -- guest
Route::get('/blog/home', [UserController::class, 'index'])->name('user.home');
Route::get('/blog/get/{id}', [UserController::class, 'get'])->name("blog.get");
Route::get('/blog/category/{id}', [UserController::class, 'getByCategory'])->name('blog.category');
Route::post('/blog/search/', [UserController::class, 'search'])->name('blog.search');

// comment section
Route::post('/comment/store/{id}', [CommentController::class, 'store'])->name('comment.store')->middleware(['isLogin']); // post comment
// Route::get('')

// name('category.home') > {{ route('category.home') }}
// Route::get('category', ....) > {{ url('category') }}

// Route::delete('') -> <form method="POST"> @csrf @method("DELETE") </form>
// Route::get('') -> <a></a>

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
