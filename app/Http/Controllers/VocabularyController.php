<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Vocabulary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VocabularyController extends Controller
{
    public function createVocabulary(Request $request) {
        $validator = Validator::make($request->all(), [
            'vocabulary_name' => 'required|unique:vocabularies|max:255',
        ],
        $messages = [
            'vocabulary_name.unique' => 'This :attribute is repeated',
        ],
        [
            'vocabulary_name' => 'vocabulary name'
        ]);
        // return $validator->errors()->get('vocabulary_name');
        if ($validator->fails()) {
            return redirect('/dashboard')
            ->withErrors($validator)
            ->withInput();
        }
        Vocabulary::create([
            'vocabulary_name' => Str::lower($request->vocabulary_name),
        ]);
        return redirect('/dashboard');
    }

    public function dashboard() {
        $vocabulary = Vocabulary::orderByDesc('id')->get();
        // dd($vocabulary[0]->our()->where('user_id','=',Auth::user()->id)->first());
        // $vocabulary = Vocabulary::inRandomOrder()->limit(5)->get();
        return view('dashboard',['vocabularys' => $vocabulary]);
    }

    public function randomVocabulary() {
        $vocabulary = Vocabulary::inRandomOrder()->limit(10)->get();
        return view('random',['vocabularys' => $vocabulary]);
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

    public function editTranslation(Request $request, $id) {
        try {
            $translation = Translation::find($id);
            $translation->name = $request->translation;
            $translation->save();
            $json['success'] = 'Edit translation success';
            $json['data'] = $translation;
            $json['id'] = $request->id;
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
