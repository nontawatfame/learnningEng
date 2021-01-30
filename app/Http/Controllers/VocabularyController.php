<?php

namespace App\Http\Controllers;

use App\Models\LogGuess;
use App\Models\SettingGuess;
use App\Models\Translation;
use App\Models\Vocabulary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Models\Our;

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
        $vocabulary = Vocabulary::orderByDesc('id')->paginate(10);
        $datetime = Carbon::now()->isoFormat('YYYY-MM-DD');
        $logGuess = LogGuess::where('created_at','like', $datetime."%")->get();
        $logGuessAll = LogGuess::all();
        $numGuessAll = 0;
        $knowAll = 0;
        $dontKnowAll = 0;
        foreach ($logGuessAll as $guesss) {
            $knowAll += $guesss->know;
            $dontKnowAll += $guesss->dont_know;
        }
        foreach ($logGuess as $log) {
            $numGuessAll += $log->know + $log->dont_know;
        }
        return view('dashboard',['vocabularys' => $vocabulary, 'numGuessAll' => $numGuessAll, 'guessAll' => $logGuessAll->count(), 'knowAll' => $knowAll, 'dontKnowAll' => $dontKnowAll]);
    }

    public function randomVocabulary() {
        $setting = SettingGuess::where('user_id', '=', Auth::user()->id)->first();
        $datetime = Carbon::now()->isoFormat('YYYY-MM-DD');
        $logGuess = LogGuess::where('created_at','like', $datetime."%")->get();
        $numGuessAll = 0;
        $knowAll = 0;
        $dontKnowAll = 0;
        if ($setting->operator === 'less') {
            $operator = '<=';
        } elseif ($setting->operator === 'more'){
            $operator = '>=';
        }
        if ($setting === null) {
            $setting = new SettingGuess();
            $setting->user_id = Auth::user()->id;
            $setting->operator = 'less';
            $setting->value = '0';
            $setting->type_guess = 'none';
            $setting->save();
        } else {
            $vocabulary = Vocabulary::inRandomOrder()->limit(10)->get();
        }
        $vocabulary = Vocabulary::all();
        $array = [];
        foreach ($vocabulary as $voc) {
            if ($voc->our === null) {
               $our = new Our();
               $our->vocabulary_id = $voc->id;
               $our->user_id = Auth::user()->id;
               $our->know = 0;
               $our->dont_know = 0;
               $our->save();
               if ($setting->type_guess === 'none') {
                    $our_v = Our::where('id','=', $our->id)->where('user_id','=',Auth::user()->id)->first();
               } else {
                    $our_v = Our::where('id','=', $our->id)->where('user_id','=',Auth::user()->id)->where($setting->type_guess , $operator ,$setting->value)->first();
               }
            } else {
                if ($setting->type_guess === 'none') {
                    $our_v = $voc->our()->where('user_id','=',Auth::user()->id)->first();
                } else {
                    $our_v = $voc->our()->where('user_id','=',Auth::user()->id)->where($setting->type_guess ,$operator ,$setting->value)->first();
                }
            }
            if ($our_v !== null) {
                array_push($array, $voc);
            }
        }
        if (count($array) >= 10) {
            $items = Arr::random($array, 10);
        } else {
            $items = $array;
        }
        foreach ($logGuess as $log) {
            $numGuessAll += $log->know + $log->dont_know;
            $knowAll += $log->know;
            $dontKnowAll += $log->dont_know;
        }

        return view('random',['vocabularys' => $items, 'setting' => $setting ,'numAll' => $numGuessAll, 'knowAll' => $knowAll, 'dontKnowAll' => $dontKnowAll]);
    }

    public function editVocabulary(Request $request) {
        try {
            $vocabulary = Vocabulary::find($request->id);
            $vocabulary->vocabulary_name = Str::lower($request->vocabulary_name);
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

    public function settingRondom(Request $request) {
        $setting = SettingGuess::where('user_id', '=', Auth::user()->id)->first();
        if ($setting === null) {
            $setting = new SettingGuess();
            $setting->user_id = Auth::user()->id;
            $setting->operator = $request->operator;
            $setting->value = $request->valueGuess;
            $setting->type_guess = $request->typeGuess;
            $setting->save();
        } else {
            $setting->operator = $request->operator;
            $setting->value = ($request->valueGuess !== null) ? $request->valueGuess : "0";
            $setting->type_guess = $request->typeGuess;
            $setting->save();
        }
        return $setting;
    }
}
