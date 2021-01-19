<?php

namespace App\Http\Controllers;

use App\Models\Our;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $json['success'] = 'success';
            $json['vocabulary_id'] = $request->id;
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
            $json['success'] = 'success';
            $json['vocabulary_id'] = $request->id;
            return $json;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
