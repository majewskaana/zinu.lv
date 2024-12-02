<?php

namespace App\Http\Controllers;
use App\Models\Subjects;
use App\Models\PrivateTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        'subject_id' => 'required|exists:subjects,id',
    ]);

    $image = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
    }

    $teacher = PrivateTeacher::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'contact_info' => $request->contact_info,
        'city' => $request->city,
        'image_path' => $image,
        'material_style' => $request->material_style,
        'about_private_teacher' => $request->about_private_teacher,
        'subject_id' => $request->subject_id,
    ]);

    return redirect()->route('teacherCreation.create')->with('success', 'Privātskolotājs ir veiksmīgi pievienots!');
}

}
