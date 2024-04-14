<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
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

Auth::routes();

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::resource('comments', CommentController::class);
Route::resource('posts', PostController::class);
//Route::resource('users', 'UserController');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
