<?php

namespace App\Http\Controllers;
use App\Models\Subjects;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class subjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $subjects = Subjects::with('themes')->get();
        if(Auth::id()){
            $usertype = Auth()->user()->usertype;
        if ($usertype == 'admin') {
        return view('admin.subjects', compact('subjects'));
    }
    else {
        return redirect()->back();
    }
    }
    }

    public function create()
    {
        if(Auth::id()){
            $usertype = Auth()->user()->usertype;
        if ($usertype == 'admin') {
        return view('admin.subjectCreation'); 
    }
        else {
        return redirect()->back();
    }
}
}
public function store(Request $request)
{
    $validated = $request->validate([
        'subject_name' => 'required|string|max:255',
        'subject_form' => 'required|string|max:255',
        'theme_name' => 'required|array',
        'theme_name.*' => 'required|string|max:255',
    ]);

    $subject = Subjects::create([
        'name' => $request->subject_name,
        'form' => $request->subject_form,
    ]);

    if (!empty($validated['theme_name'])) {
        foreach ($validated['theme_name'] as $index => $themeName) {
            Theme::create([
                'text' => $themeName,
                'macibu_prieksmets_id' => $subject->id,
            ]);
        }
    }

    return redirect()->route('subjects.index')->with('success', 'Mācību priekšmets ir pievienots!');
}

public function edit($id)
{
    $subject = Subjects::findOrFail($id);
    return view('admin.subjectEdit', compact('subject'));
}

public function update(Request $request, $id)
{
    $subject = Subjects::findOrFail($id);

    $request->validate([
        'subject_name' => 'required|string|max:255',
        'subject_form' => 'required|string|max:255',
        'theme_name' => 'array',
        'theme_name.*' => 'string',
    ]);

    $subject->update([
        'name' => $request->subject_name,
        'form' => $request->subject_form,
    ]);

    $existingThemes = $subject->themes; 
    $updatedThemes = $request->theme_name ?? []; 

    $existingThemeIds = $existingThemes->pluck('id')->toArray();
    $updatedThemeTexts = array_filter($updatedThemes); 
    $toDelete = $existingThemes->filter(function ($theme) use ($updatedThemeTexts) {
        return !in_array($theme->text, $updatedThemeTexts); 
    });

    foreach ($toDelete as $theme) {
        $theme->delete();
    }

    foreach ($updatedThemeTexts as $themeText) {
        $subject->themes()->updateOrCreate(
            ['text' => $themeText], 
            ['text' => $themeText]  
        );
    }

    return redirect()->route('subjects.index')->with('success', 'Mācību priekšmets ir veiksmīgi atjaunināts!');
}


public function destroy($id)
{
    $subject = Subjects::findOrFail($id);
    $subject->themes()->delete();
    $subject->delete(); 

    return redirect()->route('subjects.index')->with('success', 'Mācību priekšmets ir veiksmīgi izdzēsts!');
}


}
