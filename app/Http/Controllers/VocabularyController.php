<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{
    public function createVocabulary(Request $request) {
        Vocabulary::create([
            'vocabulary_name' => $request->vocabulary_name,
        ]);
        return redirect('/dashboard');
    }

    public function dashboard() {
        $vocabulary = Vocabulary::orderByDesc('id')->get();
        return view('dashboard',['vocabularys' => $vocabulary]);
    }
}
