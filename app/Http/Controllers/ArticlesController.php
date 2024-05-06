<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
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
        //echo($articles);
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

    public function createArticle() {
        return view('createArticle');
    }

    public function store(Request $request) {
        $article = new Article();
        $article->ab_name = $request->input('ab_name');
        $article->ab_description = $request->input('ab_description');
        $article->ab_price = $request->input('ab_price');
        $article->ab_creator_id = $request->input('ab_creator_id');
        $article->ab_createdate = now()->format('d.m.y H:i');
        $article->save();

        return redirect('/articles');
    }

    public function deleteArticle($id) {
        $article = Article::find($id);
        $article->delete();
        return redirect('/articles');
    }
}
