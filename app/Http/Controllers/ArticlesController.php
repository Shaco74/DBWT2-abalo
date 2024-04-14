<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\SearchArticle;
use Illuminate\Http\Request;


class ArticlesController extends Controller {

    
    public function index(Request $request) {
        $searchTerm = $request->input('search');

        // Datenbankabfrage, um Artikel zu finden, die den Suchbegriff enthalten
        $articles = SearchArticle::query()
            ->where('ab_name', 'ilike', "%$searchTerm%")
            ->get();

        if ($articles->isEmpty()) {
            $articles = SearchArticle::all();
        }
        return view('articles', ['articles' => $articles]);
    }
}
