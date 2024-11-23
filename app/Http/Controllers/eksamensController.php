<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
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
                return view('user.exam');
            }
            else {
                return view('auth.login');
            }
        }

        
    }
}
