<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\PrivateTeacher;

class FeedbackController extends Controller
{
    public function store(Request $request, PrivateTeacher $teacher)
    {
        $request->validate([
            'text' => 'required|string|max:10000',
        ]);

        $teacher->feedbacks()->create([
            'text' => $request->text,
            'leftUser' => auth()->id(),
        ]);

        return back()->with('success', 'Atsauksme veiksmīgi pievienota!');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return back()->with('success', 'Atsauksme veiksmīgi dzēsta!');
    }

}
