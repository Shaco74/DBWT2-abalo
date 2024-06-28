<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//API
Route::get('/articles', [App\Http\Controllers\ArticlesController::class, 'search_api']);
Route::post('/articles/store', [App\Http\Controllers\ArticlesController::class, 'store_api']);

Route::post('/shoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'addArticleToCart']);
Route::post('/shoppingcart/remove', [App\Http\Controllers\ShoppingCartController::class, 'removeArticleFromCart']);
Route::get('/shoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'getShoppingCart']);
//Route::get('/shoppingcart/items/ids', [App\Http\Controllers\ShoppingCartController::class, 'getItemIdsFromCart']);
Route::post('/shoppingcart/buy', [App\Http\Controllers\ShoppingCartController::class, 'buy']);

//Shopping cart
Route::post('/cart/add', [App\Http\Controllers\ShoppingCartController::class, 'add']);
Route::delete('/cart/remove', [App\Http\Controllers\ShoppingCartController::class, 'remove']);

Route::post('/articles/{id}/sold', [App\Http\Controllers\ArticlesController::class, 'sold']);
