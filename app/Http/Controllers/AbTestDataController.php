<?php

namespace App\Http\Controllers;

use App\Models\SearchArticle;
use Illuminate\Http\Request;

class AbTestDataController extends Controller {
    public function index() {
        $testData = SearchArticle::all();
        return view('testdata.index', ['testData' => $testData]);
    }

    public function store(Request $request) {
        $data = $request->validate(['ab_testname' => ['required'],]);

        return SearchArticle::create($data);
    }

    public function show(SearchArticle $abTestData) {
        return $abTestData;
    }

    public function update(Request $request, SearchArticle $abTestData) {
        $data = $request->validate(['ab_testname' => ['required'],]);

        $abTestData->update($data);

        return $abTestData;
    }

    public function destroy(SearchArticle $abTestData) {
        $abTestData->delete();

        return response()->json();
    }
}
