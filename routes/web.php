<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\privatskolotajiController;
use App\Http\Controllers\eksamensController;
use App\Http\Controllers\subjectController;
use App\Models\Theme;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/privatskolotaji', [privatskolotajiController::class, 'index'])->name('privatskolotaji');
Route::get('/sadarbiba', [privatskolotajiController::class, 'sadarbiba'])->name('sadarbiba');
Route::get('/exam', [eksamensController::class, 'index'])->name('exam');

Route::get('/exam/create', [eksamensController::class, 'create'])->name('examCreation.create');

Route::get('/get-themes', function (Request $request) {
    $subjectId = $request->input('subject_id');

    if (!$subjectId) {
        return response()->json(['error' => 'Subject ID not provided'], 400);
    }
    try {
        $themes = Theme::where('macibu_prieksmets_id', $subjectId)->get();
        
        if ($themes->isEmpty()) {
            return response()->json(['error' => 'No themes found for this subject'], 404);
        }
        return response()->json(['themes' => $themes]);
    } catch (\Exception $e) {
        \Log::error('Error loading themes: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
});




Route::post('/exam', [eksamensController::class, 'store'])->name('examCreation.store');

Route::get('/subjects', [subjectController::class, 'index'])->name('subjects.index');
Route::get('/subject/create', [subjectController::class, 'create'])->name('subjectCreation.create');
Route::post('/subject', [subjectController::class, 'store'])->name('subjectCreation.store');
Route::get('/subjects/{id}/edit', [subjectController::class, 'edit'])->name('subjectEdit.edit');
Route::put('/subjects/{id}', [subjectController::class, 'update'])->name('subjectEdit.update');
Route::delete('/subjects/{id}', [subjectController::class, 'destroy'])->name('subjectEdit.destroy');


Route::get('/teacher/create', [privatskolotajiController::class, 'create'])->name('teacherCreation.create');
Route::post('/teacher', [privatskolotajiController::class, 'store'])->name('teacherCreation.store');