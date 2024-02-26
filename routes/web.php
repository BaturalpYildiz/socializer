<?php

use App\Models\Post;
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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::middleware(
    [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ]
)->group(
    function () {
        Route::get(
            '/dashboard',
            function () {
                return view('dashboard');
            }
        )->name('dashboard');

        Route::get(
            'posts',
            function () {
                return view('posts.index');
            }

        )->name('posts');
        Route::get(
            'posts/create',
            function () {
                return view('posts.create');
            }
        )->name('posts.create');
        Route::get(
            'posts/{id}/edit',
            function () {
                if (empty(request()->route('id')) || !Post::find(request()->route('id'))) {
                    return redirect()->route('posts')->withErrors('Post not found');
                }
                return view('posts.edit');
            }
        )->name('posts.edit');
        Route::get(
            'posts/{post}',
            function () {
                return view('posts.show');
            }
        )->name('posts.show');
    }
);
