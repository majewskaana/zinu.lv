<?php

namespace App\Http\Controllers;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;
use App\Models\Answers;
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
            
            if ($usertype == 'user') {
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
        return view('admin.examCreation', compact('temas')); 
    }
    else {
        return redirect()->back();
    }
}
}
    public function store(Request $request)
{
    $request->validate([
        'gads' => 'required|year',
        'uzdevums' => 'required|string',
        'tema_id' => 'required|exists:temas,id',
        'variants' => 'required|array',
        'correct_variant' => 'required|integer|in:0,' . (count($request->variants) - 1),
    ]);

    $exam = Exam::create([
        'gads' => $request->gads,
        'uzdevums' => $request->uzdevums,
        'tema_id' => $request->tema_id,
    ]);

    foreach ($request->variants as $index => $variant) {
        $answer = new Answers([
            'text' => $variant,
            'is_correct' => $index == $request->correct_variant
        ]);
        $exam->answers()->save($answer);
    }

    return redirect()->route('admin.examCreation')->with('success', 'Eksāmens ir veiksmīgi pievienots!');
}

}
