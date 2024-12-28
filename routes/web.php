<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\privatskolotajiController;
use App\Http\Controllers\eksamensController;
use App\Http\Controllers\subjectController;
use App\Http\Controllers\FeedbackController;
use App\Models\Theme;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/sadarbiba', [privatskolotajiController::class, 'sadarbiba'])->name('sadarbiba');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/exams', [eksamensController::class, 'index'])->name('examList');
    Route::get('/exams/create', [eksamensController::class, 'create'])->name('examCreation.create');
    Route::post('/exams', [eksamensController::class, 'store'])->name('examCreation.store');
    Route::get('/exams/{id}/edit', [eksamensController::class, 'edit'])->name('examEdit.edit');
    Route::put('/exams/{id}', [eksamensController::class, 'update'])->name('examEdit.update');
    Route::delete('/exams/{id}', [eksamensController::class, 'destroy'])->name('examEdit.destroy');
    Route::get('/exams/{id}', [eksamensController::class, 'show'])->name('examDetails');
    Route::delete('/admin/exam/delete-task/{taskId}', [eksamensController::class, 'deleteTask']);
    Route::delete('/admin/exam/delete-answer/{answerId}', [eksamensController::class, 'deleteAnswer']);
});
    Route::get('/get-themes', function (Request $request) {
    $subjectId = $request->input('subject_id');
    $themes = Theme::where('macibu_prieksmets_id', $subjectId)->get();

    return response()->json(['themes' => $themes]);
    
});


Route::post('/exam', [eksamensController::class, 'store'])->name('examCreation.store');
Route::get('/exams/{id}/start', [eksamensController::class, 'start'])->name('exams.start');
Route::post('/exams/{id}/submit', [eksamensController::class, 'submit'])->name('exams.submit');


Route::get('/subjects', [subjectController::class, 'index'])->name('subjects.index');
Route::get('/subject/create', [subjectController::class, 'create'])->name('subjectCreation.create');
Route::post('/subject', [subjectController::class, 'store'])->name('subjectCreation.store');
Route::get('/subjects/{id}/edit', [subjectController::class, 'edit'])->name('subjectEdit.edit');
Route::put('/subjects/{id}', [subjectController::class, 'update'])->name('subjectEdit.update');
Route::delete('/subjects/{id}', [subjectController::class, 'destroy'])->name('subjectEdit.destroy');


Route::get('/teachers', [privatskolotajiController::class, 'index'])->name('teacherList');
Route::get('/teachers/{id}', [privatskolotajiController::class, 'show'])->name('teacher.profile');
Route::get('/teacher/create', [privatskolotajiController::class, 'create'])->name('teacherCreation.create');
Route::post('/teacher', [privatskolotajiController::class, 'store'])->name('teacherCreation.store');
Route::get('/teachers/{id}/edit', [privatskolotajiController::class, 'edit'])->name('teacherEdit.edit');
Route::put('/teachers/{id}', [privatskolotajiController::class, 'update'])->name('teacherEdit.update');
Route::delete('/teachers/{id}', [privatskolotajiController::class, 'destroy'])->name('teacherEdit.destroy');

Route::post('/teachers/{teacher}/feedback', [FeedbackController::class, 'store'])->middleware('auth')->name('feedback.store');
Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->middleware('auth')->name('feedback.destroy');