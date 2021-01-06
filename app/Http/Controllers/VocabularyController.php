<?php

namespace App\Http\Controllers;

use App\Models\Translation;
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
            return $vocabulary;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteVocabulary($id) {
        try {
            Vocabulary::destroy($id);
            $translations = Translation::where('vocabulary_id','=', $id)->get();
            foreach($translations as $tran) {
                $tran->delete();
            }
            $json['success'] = 'Delete success';
            $json['id'] = $id;
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function createTranslation(Request $request) {
        try {
            $translation = new Translation;
            $translation->name = $request->translation;
            $translation->vocabulary_id = $request->id;
            $translation->save();
            $json['success'] = 'Create translation success';
            $json['data'] = $translation;
            $json['id'] = $request->id;
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteTranslation($id) {
        try {
            Translation::destroy($id);
            $json['success'] = 'Delete success';
            $json['id'] = $id;
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
