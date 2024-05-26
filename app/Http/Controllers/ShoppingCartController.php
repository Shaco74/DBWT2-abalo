<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ShoppingCartController extends Controller
{
    public function add(Request $request)
    {
        $articleId = $request->input('articleId');
        $quantity = $request->input('quantity');

        $cart = $request->session()->get('cart', []);
        $cart[$articleId] = $quantity;
        $request->session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request)
    {
        $articleId = $request->input('articleId');

        $cart = $request->session()->get('cart', []);
        unset($cart[$articleId]);
        $request->session()->put('cart', $cart);

        return redirect('/cart/show');
    }

    public function show(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $articles = [];
        foreach ($cart as $articleId => $quantity) {
            $article = Article::find($articleId);
            $article->quantity = $quantity;
            $article->image = $this->getArticleImage($article);
            $articles[] = $article;
        }

        return view('shoppingCart', ['articlesCart' => $articles]);
    }

    private function getArticleImage($article)
    {
        // Implementiere die Logik, um das Bild des Artikels zu holen
        return $article->image_url; // Beispiel für ein Bild-URL-Feld
    }
}
