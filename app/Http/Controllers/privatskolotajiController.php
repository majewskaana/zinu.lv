<?php

namespace App\Http\Controllers;
use App\Models\Subjects;
use App\Models\PrivateTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class privatskolotajiController extends Controller
{
    public function index(Request $request)
    {
        $query = PrivateTeacher::query();
        $subjects = Subjects::all();

        // Filter by city if provided in the request
        if ($request->has('city') && $request->city) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        
        // Filter by subject if provided in the request
        if ($request->has('subject') && $request->subject) {
            $query->whereHas('macibuPrieksmeti', function ($q) use ($request) {
                $q->where('subjects.id', $request->subject);
            });
        }

        // Filter by form if provided in the request
        if ($request->has('form') && $request->form) {
            $query->whereHas('macibuPrieksmeti', function ($q) use ($request) {
                $q->where('subjects.form', $request->form);
            });
        }
        
        // Execute the query to get the list of teachers
        $teachers = $query->get(); 
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            if($usertype == 'admin'){
                return view('admin.teacherList', compact('teachers', 'subjects'));
            }
            else {
                return view('teacherList', compact('teachers', 'subjects'));
            }
        }
        else{
            return view('teacherList', compact('teachers', 'subjects'));
        }
        
    }
    
    public function sadarbiba()
    {
        return view('privatskolotajiRequirements');
    }

    public function create()
    {
        if(Auth::id()){
            $usertype = Auth()->user()->usertype;
        if ($usertype == 'admin') {
            $subjects = Subjects::all();
            return view('admin.teacherCreation', compact('subjects')); 
    }
    else {
        return redirect()->back();
    }
}
}

    public function store(Request $request)
{

    $request->validate([
        'name' => 'required|string',
        'surname' => 'required|string',
        'contact_info' => 'required|string',
        'city' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'material_style' => 'required|string',
        'about_private_teacher' => 'required|string',
        'subject_id' => 'required|array|min:1', 
        'subject_id.*' => 'integer|exists:subjects,id', 
    ]);

    $imagePath = $request->file('image')->store('teachers', 'public');

    $teacher = PrivateTeacher::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'contact_info' => $request->contact_info,
        'city' => $request->city,
        'image_path' => $request->image,
        'material_style' => $request->material_style,
        'about_private_teacher' => $request->about_private_teacher,
    ]);

    if ($request->has('subject_id') && is_array($request->subject_id)) {
    $teacher->macibuPrieksmeti()->attach($request->subject_id);
}


    return redirect()->route('teacherList')->with('success', 'Privātskolotājs ir veiksmīgi pievienots!');
}

        public function show($id)
    {
        $teacher = PrivateTeacher::findOrFail($id);

        return view('teacherProfile', compact('teacher'));
    }

    public function edit($id)
    {
        $teacher = PrivateTeacher::findOrFail($id);
        $subjects = Subjects::all();
        return view('admin.teacherEdit', compact('teacher', 'subjects'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'contact_info' => 'nullable|string|max:255', 
        'city' => 'required|string|max:255',
        'about_private_teacher' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        'subject_id' => 'nullable|array|min:1', 
        'subject_id.*' => 'integer|exists:subjects,id', 
    ]);

    $teacher = PrivateTeacher::findOrFail($id);

    if ($request->hasFile('image')) {
        if ($teacher->image_path) {
            Storage::delete('public/' . $teacher->image_path); 
        }
        $imagePath = $request->file('image')->store('images', 'public'); 
    } else {
        $imagePath = $teacher->image_path;
    }

    $teacher->update([
        'name' => $request->name,
        'surname' => $request->surname,
        'contact_info' => $request->contact_info,
        'city' => $request->city,
        'image_path' => $request->image,
        'material_style' => $request->material_style,
        'about_private_teacher' => $request->about_private_teacher,
    ]);

    if ($request->has('subjects')) {
        $teacher->macibuPrieksmeti()->sync($request->subjects);
    }

    $teacher->save();
    return redirect()->route('teacherList')->with('success', 'Skolotājs veiksmīgi atjaunināts.');
}



    public function destroy($id)
    {
        $teacher = PrivateTeacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teacherList')->with('success', 'Skolotājs veiksmīgi izdzēsts.');
    }
}
