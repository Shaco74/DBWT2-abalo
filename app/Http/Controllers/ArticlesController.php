<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\SearchArticle;
use Illuminate\Http\Request;


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
        $articles = SearchArticle::query()->where('ab_name', 'ilike', "%$searchTerm%")->get();

        if ($articles->isEmpty()) {
            $articles = SearchArticle::all();
        }

        // add image to each article
        foreach ($articles as $article) {
            $article->image = $this->getArticleImage($article);
        }
        //echo($articles);
        return view('articles', ['articles' => $articles]);
    }

    private function getArticleImage($article) {
        $articleId = $article->id;
        $imagePath = 'media/articleImages/' . $articleId . '.jpg';
        $articleImage = public_path($imagePath);
        if (file_exists($articleImage)) {
            return asset($imagePath);
        } else {
            return "";
        }
    }
}
