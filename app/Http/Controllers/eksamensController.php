<?php

namespace App\Http\Controllers;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Models\Subjects;
use App\Models\Exam;
use App\Models\Answers;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    $validated = $request->validate([
        'gads' => 'required|numeric',
        'limenis' => 'required|string|max:255',
        'subject_id' => 'required|exists:subjects,id',
        'tasks' => 'required|array',
        'tasks.*.text' => 'required|string|max:255',
        'tasks.*.tema_id' => 'required|exists:themes,id',
        'tasks.*.variants' => 'required|array',
        'tasks.*.variants.*' => 'required|string|max:255',
        'tasks.*.correct_variant' => 'required|numeric',
    ]);

    $exam = Exam::create([
        'gads' => $validated['gads'],
        'limenis' => $validated['limenis'],
        'macibu_prieksmets_id' => $validated['subject_id'],
    ]);

    foreach ($validated['tasks'] as $taskData) {
        $task = $exam->tasks()->create([
            'text' => $taskData['text'],
            'theme_id' => $taskData['tema_id'],
            'subject_id' => $validated['subject_id'],
        ]);

        foreach ($taskData['variants'] as $index => $variant) {
            $isCorrect = $index == $taskData['correct_variant'];
            $task->answers()->create([
                'text' => $variant,
                'is_correct' => $isCorrect,
            ]);
        }
    }

    return redirect()->route('examList')->with('success', 'Eksāmens tika veiksmīgi pievienots!');
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

    $exam->update([
        'gads' => $request->gads,
        'limenis' => $request->limenis,
        'macibu_prieksmets_id' => $request->macibu_prieksmets_id,
    ]);

    if ($request->has('tasks')) {
        foreach ($request->tasks as $taskId => $taskData) {
            $task = Tasks::findOrFail($taskId);
            $task->update([
                'text' => $taskData['text'],
            ]);

            if (isset($taskData['answers'])) {
                foreach ($taskData['answers'] as $answerId => $answerData) {
                    $answer = Answers::findOrFail($answerId);

                    $isCorrect = isset($answerData['is_correct']) && $answerData['is_correct'] === 'on';

                    $answer->update([
                        'text' => $answerData['text'],
                        'is_correct' => $isCorrect,
                    ]);
                }
            }
        }
    }

    if ($request->has('new_tasks')) {
        foreach ($request->new_tasks as $newTask) {
            $task = $exam->tasks()->create([
                'text' => $newTask['text'],
            ]);

            if (isset($newTask['answers'])) {
                foreach ($newTask['answers'] as $newAnswer) {

                    $isCorrect = isset($newAnswer['is_correct']) && $newAnswer['is_correct'] === 'on';

                    $task->answers()->create([
                        'text' => $newAnswer['text'],
                        'is_correct' => $isCorrect,
                    ]);
                }
            }
        }
    }

    if ($request->has('new_answers')) {
        foreach ($request->new_answers as $taskId => $answers) {
            $task = Tasks::findOrFail($taskId);
            foreach ($answers as $newAnswer) {
                $isCorrect = isset($newAnswer['is_correct']) && $newAnswer['is_correct'] === 'on';
                $task->answers()->create([
                    'text' => $newAnswer['text'],
                    'is_correct' => $isCorrect,
                ]);
            }
        }
    }

    return redirect()->route('examList')->with('success', 'Eksāmens atjaunināts!');
}



    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->route('examList')->with('success', 'Eksāmens veiksmīgi izdzēsts!');
    }

    public function show($id)
    {
        $exam = Exam::with('tasks.answers')->findOrFail($id);

        if (Auth::user()->usertype == 'admin') {
            return view('admin.examDetails', compact('exam'));
        } else {
            return redirect()->route('examList');
        }
    }

}
