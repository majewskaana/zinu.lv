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
                $exams = Exam::all();
                return view('admin.examList', compact('exams'));
            }
            elseif ($usertype == 'user') {
                $exams = Exam::all();
                return view('user.examList', compact('exams'));
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
    // Валидация данных
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
    ]);

    $task = Tasks::create([
        'text' => $request->uzdevums,
        'subject_id' => $request->subject_id,
        'theme_id' => $request->tema_id,
        'exam_id' => $exam->id,
    ]);

    foreach ($request->variants as $index => $variant) {
        $answer = new Answers([
            'text' => $variant,
            'is_correct' => $index == $request->correct_variant,
        ]);
        $task->answers()->save($answer);
    }

    return redirect()->route('examList')->with('success', 'Eksāmens ir veiksmīgi pievienots!');
}

public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        $subjects = Subjects::all();
        return view('admin.examEdit', compact('exam', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $request->validate([
            'gads' => 'required|date_format:Y',
            'limenis' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $exam->update([
            'gads' => $request->gads,
            'limenis' => $request->limenis,
            'macibu_prieksmets_id' => $request->subject_id,
        ]);

        return redirect()->route('examList')->with('success', 'Eksāmens veiksmīgi atjaunināts!');
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->route('examList')->with('success', 'Eksāmens veiksmīgi izdzēsts!');
    }

    public function show($id)
    {
        $exam = Exam::with('uzdevums.answers')->findOrFail($id);

        if (Auth::user()->usertype == 'admin') {
            return view('admin.examDetails', compact('exam'));
        } else {
            return redirect()->route('examList');
        }
    }

}
