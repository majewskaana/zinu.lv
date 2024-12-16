<?php

namespace App\Http\Controllers;
use App\Models\Subjects;
use App\Models\PrivateTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class privatskolotajiController extends Controller
{
    public function index()
    {
        return view('privatskolotaji');
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


    return redirect()->route('teacherCreation.create')->with('success', 'Privātskolotājs ir veiksmīgi pievienots!');
}


}
