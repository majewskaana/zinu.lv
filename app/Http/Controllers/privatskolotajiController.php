<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
