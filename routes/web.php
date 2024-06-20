<?php

use Illuminate\Support\Facades\Route;

Route::get('/csrf', function () {return csrf_token();});

//Welcome page
Route::get('/', function () {return view('welcome');});

//Login and logout
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

//Playground
Route::get('/playground', function () {return view('components.javascript-playground');})->name('playground');

//Show articles
Route::get('/articles', [App\Http\Controllers\ArticlesController::class, 'index']);
Route::get('/articles/{article}', [App\Http\Controllers\ArticlesController::class, 'show']);

//Article creation
Route::get('/newarticle', function () {return view('createArticle');});
Route::post('/articles/store', [App\Http\Controllers\ArticlesController::class, 'store']);

//Cookie handling
Route::get('/disagreecookies', function () {return view('components.disagree-cookie');});


//Shopping cart
Route::get('/cart/show', [App\Http\Controllers\ShoppingCartController::class, 'showCart']);

Route::get('newsite', function () {
    return view('newsite');
});
