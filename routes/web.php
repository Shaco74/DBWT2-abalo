<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');
Route::get('/playground', function () {return view('components.javascript-playground');})->name('playground');

Route::get('/articles', [App\Http\Controllers\ArticlesController::class, 'index']);
Route::get('/articles/{article}', [App\Http\Controllers\ArticlesController::class, 'show']);
Route::post('/articles', [App\Http\Controllers\ArticlesController::class, 'store'])->name('articles.store');
Route::get('/create', [App\Http\Controllers\ArticlesController::class, 'createArticle']);

