<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Util\TimeUtil;

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
        redirect('/cart/show');
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

    public function search_api(Request $request) {
        $searchTerm = $request->query('search');
        if ($searchTerm === null) {
            return response()->json(['articles' => []]);
        }
        $articles = Article::query()->where('ab_name', 'ilike', "%$searchTerm%")->get();
        return response()->json(['articles' => $articles]);
    }

    public function store_api(Request $request){

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

            return response()->json(['id' => $article->id],201);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while creating the article: ' . $e->getMessage()], 500);
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
}
