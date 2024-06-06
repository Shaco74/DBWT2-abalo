<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Shoppingcart;
use App\Models\ShoppingcartItem;
use Exception;
use Illuminate\Http\Request;

/**
 * Controller for the Article model.
 */
/**
 * Class ShoppingCartController <br>
 * Controlling the shopping cart
 *
 * Functions: <br>
 * addArticleToCart(Request $request) <br>
 * getShoppingCart(Request $request) <br>
 * getItemIdsFromCart(Request $request) <br>
 * removeArticleFromCart(Request $request) <br>
*/
class ShoppingCartController extends Controller {
   public function addArticleToCart(Request $request) {
    try {
        $articleId = $request->input('articleId');
        $shoppingCartId = 99; // Die ID des Shoppingcarts, auf das sich das Item beziehen soll

        // Überprüfe, ob das Shoppingcart mit der ID 99 existiert
        $shoppingCart = Shoppingcart::find($shoppingCartId);
        if (!$shoppingCart) {
            // Falls nicht, erstelle das Shoppingcart
            $shoppingCart = new Shoppingcart();
            $shoppingCart->id = 99;
            $shoppingCart->ab_creator_id = 99; // Replace $userId with the actual user ID
            $shoppingCart->ab_createdate = now();
            $shoppingCart->save();
        }

        // Check if the article with the given ID exists
        $article = Article::find($articleId);
        if (!$article) {
            return response()->json(['error' => 'Der Artiekel mit der angegebenen ID ist nicher vorhanden'], 404);
        }

        // Check if the article is already in the shopping cart
        $existingItem = ShoppingcartItem::where('ab_article_id', $articleId)
            ->where('ab_shoppingcart_id', $shoppingCartId)
            ->first();

        if ($existingItem) {
            return response()->json(['error' => 'Der Artikel ist bereits im Shoppuingcart'], 400);
        }

        // Speichere das neue Item in der Datenbank und referenziere das Shoppingcart
        $shoppingCartItem = new ShoppingcartItem();
        $shoppingCartItem->ab_article_id = $articleId;
        $shoppingCartItem->ab_shoppingcart_id = $shoppingCartId;
        $shoppingCartItem->ab_createdate = now(); // Verwende den aktuellen Zeitstempel
        $shoppingCartItem->save();

        // Falls du die ID des neuen Eintrags zurückgeben möchtest
        return response()->json(['id' => $shoppingCartItem->id], 201);

    } catch (Exception $e) {
        $errorMessage = 'An error occurred while adding the article to the cart: ' . $e->getMessage();
        return response()->json(['error' => $errorMessage], 500);
    }
}

    public function getShoppingCart(Request $request) {
        try {
            $shoppingCartId = 99; // Die ID des Shoppingcarts, das abgerufen werden soll

            // Überprüfe, ob das Shoppingcart mit der ID 99 existiert
            $shoppingCart = Shoppingcart::find($shoppingCartId);
            if (!$shoppingCart) {
                return response()->json(['error' => 'Shopping cart not found'], 404);
            }

            // Suche alle Items, die zum Shoppingcart gehören
            $shoppingCartItems = ShoppingcartItem::where('ab_shoppingcart_id', $shoppingCartId)->get();

            // Falls du die Items zurückgeben möchtest
            return response()->json(['items' => $shoppingCartItems], 200);

        } catch (Exception $e) {
            $errorMessage = 'An error occurred while getting the shopping cart: ' . $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    public function getItemIdsFromCart(Request $request) {
        try {
            $shoppingCartId = 99; // Die ID des Shoppingcarts, das abgerufen werden soll

            // Überprüfe, ob das Shoppingcart mit der ID 99 existiert
            $shoppingCart = Shoppingcart::find($shoppingCartId);
            if (!$shoppingCart) {
                return response()->json(['error' => 'Shopping cart not found'], 404);
            }

            // Suche alle Items, die zum Shoppingcart gehören
            $shoppingCartItems = ShoppingcartItem::where('ab_shoppingcart_id', $shoppingCartId)->get();

            // Extrahiere die IDs der Items
            $itemIds = $shoppingCartItems->pluck('ab_article_id');

            // filter itemIds to be just unique ones
            $itemIds = $itemIds->unique();

            // Falls du die IDs zurückgeben möchtest
            return response()->json(['itemIds' => $itemIds], 200);

        } catch (Exception $e) {
            $errorMessage = 'An error occurred while getting the item IDs from the shopping cart: ' . $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    public function removeArticleFromCart(Request $request) {
        try {
            $articleId = $request->input('articleId');
            $shoppingCartId = 99; // Die ID des Shoppingcarts, auf das sich das Item beziehen soll

            // Suche das Item in der Datenbank
            $shoppingCartItem = ShoppingcartItem::where('ab_article_id', $articleId)
                ->where('ab_shoppingcart_id', $shoppingCartId)
                ->first();

            if (!$shoppingCartItem) {
                return response()->json(['error' => 'Item not found in shopping cart'], 404);
            }

            // Lösche das Item aus der Datenbank
            $shoppingCartItem->delete();
            return redirect('/api/cart/show');
            //return response()->json(['message' => 'Item removed from shopping cart'], 200);

        } catch (Exception $e) {
            $errorMessage = 'An error occurred while removing the article from the cart: ' . $e->getMessage();
            return response()->json(['error' => $errorMessage], 500);
        }
    }


    public function add(Request $request) {
        $articleId = $request->input('articleId');
        $quantity = $request->input('quantity');
        $cart = $request->session()->get('cart', []);

        $cart[$articleId] = $quantity;
        $request->session()->put('cart', $cart);
        return response()->json(['success' => true]);

    }

    public function remove(Request $request) {

        $articleId = $request->input('articleId');
        $cart = $request->session()->get('cart', []);
        unset($cart[$articleId]);
        $request->session()->put('cart', $cart);
        return redirect('/api/shoppingcart');

    }

    public function showCart(Request $request) {
        //$cart = $request->session()->get('cart', []);
        $cart = $this->getShoppingCart($request);
        $cart = json_decode($cart->content());
        $itemArrayWithIds = $cart->items;

        $items = [];
        // iterate over this array and fill the items array with the corrosponding item from db
        foreach ($itemArrayWithIds as $item) {
            $article = Article::find($item->ab_article_id);
            $items[] = $article;
        }

        /*foreach ($cart as $articleId => $quantity) {
            $article = Article::find($articleId);
            $article->image = $this->getArticleImage($article);
            $article->quantity = $quantity;
            $articles[] = $article;
        }*/

        return view('shoppingCart', ['articlesCart' => $items]);
    }

    public function show(Request $request) {
        $cart = $request->session()->get('cart', []);
        $articles = [];

        foreach ($cart as $articleId => $quantity) {
            $article = Article::find($articleId);
            $article->image = $this->getArticleImage($article);
            $article->quantity = $quantity;
            $articles[] = $article;
        }

        return view('shoppingCart', ['articlesCart' => $articles]);
    }

    private function getArticleImage($article) {
        // Implementiere die Logik, um das Bild des Artikels zu holen
        return $article->image_url; // Beispiel für ein Bild-URL-Feld
    }
}
