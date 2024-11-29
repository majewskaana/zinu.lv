<?php

namespace App\Http\Controllers;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Models\Subjects;
use App\Models\Exam;
use App\Models\Answers;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;

class eksamensController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(Auth::id()){
            $usertype = Auth()->user()->usertype;
            
            if ($usertype == 'user' || $usertype == 'admin') {
                return view('user.examList');
            }
            else {
                return view('auth.login');
            }
        }
    }

    public function create()
    {
        if(Auth::id()){
            $usertype = Auth()->user()->usertype;
        if ($usertype == 'admin') {
            $temas = Theme::all(); 
            $subjects = Subjects::all();
            return view('admin.examCreation', compact('temas','subjects')); 
    }
    else {
        return redirect()->back();
    }
}
}
    public function store(Request $request)
{
    $request->validate([
        'gads' => 'required|date_format:Y',
        'uzdevums' => 'required|string',
        'limenis' => 'required|string',
        'tema_id' => 'required|exists:themes,id',
        'subject_id' => 'required|exists:subjects,id',
        'variants' => 'required|array',
        'correct_variant' => 'required|integer|in:0,' . (count($request->variants) - 1),
    ]);

    $exam = Exam::create([
        'gads' => $request->gads,
        'limenis' => $request->limenis,
        'macibu_prieksmets_id' => $request->subject_id,
        'uzdevums' => $request->uzdevums,
    ]);

    $exam = Tasks::create([
        'text' => $request->uzdevums,
        'Subject' => $request->subject_id,
        'theme_id' =>$request->tema_id
    ]);

    foreach ($request->variants as $index => $variant) {
        $answer = new Answers([
            'text' => $variant,
            'is_correct' => $index == $request->correct_variant
        ]);
        $exam->answers()->save($answer);
    }

    return redirect()->route('examCreation.create')->with('success', 'Eksāmens ir veiksmīgi pievienots!');
}


}
