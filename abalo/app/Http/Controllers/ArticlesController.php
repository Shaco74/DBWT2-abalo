<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ShoppingcartItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Controller for the Article model.
 */
class ArticlesController extends Controller {

    /** Used to display searched Articles using URL query parameters. <br>
     *  If no search term is provided, all articles are displayed
     *
     *
     * @param Request $request The request object containing the search term.
     */
    public function index(Request $request) {
        $searchTerm = $request->input('search');

        // search for articles with the search term in the article name
        $articles = Article::query()->where('ab_name', 'ilike', "%$searchTerm%")->get();

        if ($articles->isEmpty()) {
            $articles = Article::all();
        }

        // add image to each article
        foreach ($articles as $article) {
            $article->image = $this->getArticleImage($article);
        }
        redirect('/api/cart/show');
        return view('articles', ['articles' => $articles]);
    }


    private function getArticleImage($article) {
        $articleId = $article->id;

        $jpgImagePath = 'media/articleImages/' . $articleId . '.jpg';
        $pngImagePath = 'media/articleImages/' . $articleId . '.png';
        $jpgArticleImage = public_path($jpgImagePath);
        $pngArticleImage = public_path($pngImagePath);

        return
            file_exists($jpgArticleImage) ? $jpgImagePath :
                (file_exists($pngArticleImage) ? $pngImagePath : '');
    }


    public function store(Request $request) {
        try {

            $article = $this->getArticle($request);

            return (response()->json(['id' => $article->id], 201) && redirect('/articles'));
        } catch (Exception $e) {
            $errorMessage = 'An error occurred while creating the article: ' . $e->getMessage();
            return view('components.error-message')->with('errorMessage', $errorMessage);
        }
    }

    /**
     * @param Request $request
     * @return Article
     */
    public function getArticle(Request $request): Article {
        $article = new Article();
        $article->ab_name = $request->input('ab_name');
        $article->ab_description = $request->input('ab_description');
        $article->ab_price = $request->input('ab_price');
        $article->ab_creator_id = $request->input('ab_creator_id');
        $article->ab_createdate = now()->format('d.m.y H:i');
        $article->save();
        return $article;
    }

    /**
     * P3: Task 7
     * Create an API endpoint that allows you to search for articles by name.
     * */
    public function search_api(Request $request) {
        $searchTerm = $request->query('search');
        $page = $request->query('page');

        $query = Article::query();

        if ($searchTerm !== null) {
            $query->where('ab_name', 'ilike', "%$searchTerm%")
                ->orWhere('ab_description', 'ilike', "%$searchTerm%")
                ->orWhere('ab_price', 'ilike', "%$searchTerm%");
        }

        if (isset($page)) {
            $offset = ($page > 0) ? ($page * 5) : 0;
            $query->offset($offset)->limit(5);
        }

        $articles = $query->get();

        foreach ($articles as $article) {
            $article->image = $this->getArticleImage($article);
            $article->isInShoppingCart = ShoppingcartItem::where('ab_article_id', $article->id)->exists();
        }

        return response()->json(['articles' => $articles]);
    }

    /**
     * P3: Task 8
     * Create an API endpoint that allows you to create an article.
     * */
    public function store_api(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'ab_name' => 'required',
                'ab_price' => 'required | numeric | min:1',
                'ab_creator_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $article = $this->getArticle($request);

            return response()->json(['id' => $article->id], 201);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the article: ' . $e->getMessage()], 500);
        }
    }

    public function sold(Request $request, $id) {
        // This would to the same as "markAsSold" but through api.
        // This wasnt used at the end to what appeared to be a deadlock
        // when calling from a controller a diffrent one thorugh api calls
        return response()->json(['success' => true]);
        $article = Article::find($id);
        $creatorId = $article->ab_creator_id;

        return response()->json(['success' => true, 'creatorId' => $creatorId]);
    }

    public function markAsSold($articleId) {
        $article = Article::find($articleId);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $creatorId = $article->ab_creator_id;
        $articleName = $article->ab_name;

        $loop = \React\EventLoop\Loop::get();
        $connector = new \Ratchet\Client\Connector($loop);

        $connector('ws://localhost:8085/sells')
            ->then(function(\Ratchet\Client\WebSocket $conn) use ($creatorId, $articleName) {
                $message = json_encode([
                    'isServer' => true,
                    'creatorId' => $creatorId,
                    'articleName' => $articleName,
                    'message' => "Your item '{$articleName}' has been sold!",
                    'timestamp' => time()
                ]);

                $conn->send($message);
                $conn->close();
            }, function(\Exception $e) {
                echo "Could not connect: {$e->getMessage()}\n";
            });

        $loop->run();

        return response()->json(['success' => true, 'creatorId' => $creatorId]);
    }

}
