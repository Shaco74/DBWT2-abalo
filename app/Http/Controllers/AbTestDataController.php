<?php

namespace App\Http\Controllers;

use App\Models\AbTestData;
use Illuminate\Http\Request;

class AbTestDataController extends Controller {
    public function index() {
        $testData = AbTestData::all();
        return view('testdata.index', ['testData' => $testData]);
    }

    public function store(Request $request) {
        $data = $request->validate(['ab_testname' => ['required'],]);

        return AbTestData::create($data);
    }

    public function show(AbTestData $abTestData) {
        return $abTestData;
    }

    public function update(Request $request, AbTestData $abTestData) {
        $data = $request->validate(['ab_testname' => ['required'],]);

        $abTestData->update($data);

        return $abTestData;
    }

    public function destroy(AbTestData $abTestData) {
        $abTestData->delete();

        return response()->json();
    }
}
