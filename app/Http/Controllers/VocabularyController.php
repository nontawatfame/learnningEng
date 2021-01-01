<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Exception;
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

    public function editVocabulary(Request $request) {
        try {
            $vocabulary = Vocabulary::find($request->id);
            $vocabulary->vocabulary_name = $request->vocabulary_name;
            $vocabulary->save();
            return $request->all();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteVocabulary($id) {
        try {
            Vocabulary::destroy($id);
            $json['success'] = 'Delete success';
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
