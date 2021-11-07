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
        $enrolled = Auth::user()->enroll->load("subject");
        return view("pages.home",compact('enrolled'));
    }
    public function subjectView(Request $request, $subject)
    {
        $subject =  Subject::where("id", $subject)->first();
        $subject->load(["user","enroll"]);
        $adviser = $subject->user;
        $students = $subject->enroll->load("student");

        return view("pages.subject", compact('subject','adviser','students'));
    }
    public function createAssessment(){
        return view("pages.createassesment");
    }
}

