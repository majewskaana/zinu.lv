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
        //
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

    return redirect()->route('subjectCreation.create')->with('success', 'Mācību priekšmets ir pievienots!');
}

}
