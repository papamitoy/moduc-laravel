<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function homeView()
    {

        return view("pages.home");
    }
    public function subjectView(Request $request, $subject)
    {
        $subject =  Subject::where("id", $subject)->first();
        return view("pages.subject", compact('subject'));
    }
}
