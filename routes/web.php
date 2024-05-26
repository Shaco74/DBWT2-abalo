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

//API
Route::get('/api/articles', [App\Http\Controllers\ArticlesController::class, 'search_api']);
Route::post('/api/articles/store', [App\Http\Controllers\ArticlesController::class, 'store_api']);

Route::post('/api/shoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'addArticleToCart']);
Route::post('/api/shoppingcart/remove', [App\Http\Controllers\ShoppingCartController::class, 'removeArticleFromCart']);
Route::get('/api/shoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'getShoppingCart']);
Route::get('/api/shoppingcart/items/ids', [App\Http\Controllers\ShoppingCartController::class, 'getItemIdsFromCart']);


//Shopping cart
Route::post('/cart/add', [App\Http\Controllers\ShoppingCartController::class, 'add']);
Route::delete('/cart/remove', [App\Http\Controllers\ShoppingCartController::class, 'remove']);
Route::get('/cart/show', [App\Http\Controllers\ShoppingCartController::class, 'showCart']);
