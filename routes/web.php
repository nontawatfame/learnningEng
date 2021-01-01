<?php

use App\Http\Controllers\VocabularyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [VocabularyController::class, 'dashboard'])->name('dashboard');
    Route::post('/add_vocabulary', [VocabularyController::class, 'createVocabulary']);
    Route::put('/edit/vocabulary', [VocabularyController::class, 'editVocabulary']);
    Route::delete('delete/vocabulary/{id}', [VocabularyController::class, 'deleteVocabulary']);
});

require __DIR__.'/auth.php';
