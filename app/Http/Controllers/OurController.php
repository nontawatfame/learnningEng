<?php

namespace App\Http\Controllers;

use App\Models\LogGuess;
use App\Models\Our;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OurController extends Controller
{
    public function incrementKnow(Request $request) {
        try {
            $our = Our::where('vocabulary_id','=', $request->id)->where('user_id','=', Auth::user()->id)->get();
            if ($our->count() === 0) {
                $our = Our::create([
                    'vocabulary_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'know' => 1,
                    'dont_know' => 0,
                ]);
            } else {
                $our[0]->increment('know');
            }
            $log = new LogGuess;
            $log->user_id = Auth::user()->id;
            $log->vocabulary_id = $request->id;
            $log->know = 1;
            $log->dont_know = 0;
            $log->save();
            $datetime = Carbon::now()->isoFormat('YYYY-MM-DD');
            $logGuess = LogGuess::where('created_at','like', $datetime."%")->get();
            $numGuessAll = 0;
            $knowAll = 0;
            $dontKnowAll = 0;
            foreach ($logGuess as $log) {
                $numGuessAll += $log->know + $log->dont_know;
                $knowAll += $log->know;
                $dontKnowAll += $log->dont_know;
            }
            $json['success'] = 'success';
            $json['vocabulary_id'] = $request->id;
            $json['numAll'] = $numGuessAll;
            $json['knowAll'] = $knowAll;
            $json['dontKnowAll'] = $dontKnowAll;
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function incrementDontKnow(Request $request) {
        try {
            $our = Our::where('vocabulary_id','=', $request->id)->where('user_id','=', Auth::user()->id)->get();
            if ($our->count() === 0) {
                $our = Our::create([
                    'vocabulary_id' => $request->id,
                    'user_id' => Auth::user()->id,
                    'know' => 0,
                    'dont_know' => 1,
                ]);
            } else {
                $our[0]->increment('dont_know');
            }
            $log = new LogGuess;
            $log->user_id = Auth::user()->id;
            $log->vocabulary_id = $request->id;
            $log->know = 0;
            $log->dont_know = 1;
            $log->save();
            $datetime = Carbon::now()->isoFormat('YYYY-MM-DD');
            $logGuess = LogGuess::where('created_at','like', $datetime."%")->get();
            $numGuessAll = 0;
            $knowAll = 0;
            $dontKnowAll = 0;
            foreach ($logGuess as $log) {
                $numGuessAll += $log->know + $log->dont_know;
                $knowAll += $log->know;
                $dontKnowAll += $log->dont_know;
            }
            $json['success'] = 'success';
            $json['vocabulary_id'] = $request->id;
            $json['numAll'] = $numGuessAll;
            $json['knowAll'] = $knowAll;
            $json['dontKnowAll'] = $dontKnowAll;
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
