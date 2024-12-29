<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profileEdit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'surname' => 'required|string|min:2|max:50',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8|max:24|confirmed',
            'city' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->city = $request->city;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('home')->with('success', 'Profils tika atjaunināts!');
    }

    public function show()
{
    $user = Auth::user();
    $completedExams = $user->completedExams()->with('macibuPrieksmets')->get();

    return view('profile', compact('user', 'completedExams')); 
}

public function destroy()
{
    $user = auth()->user();
    auth()->logout();
    $user->completedExams()->detach();
    $user->delete();

    return redirect('/');
}

}
