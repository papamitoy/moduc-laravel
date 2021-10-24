<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function createClass(Request $request)
    {
        generateCode:
        $subjectCode = rand(10000000, 9999999);
        $subject =  Subject::where("subject_code", $subjectCode)->first();
        if (!empty($subject)) {
            goto generateCode;
        }


        Auth::user()->subjects()->create([
            "class_name" => $request->className,
            "section_name" => $request->sectionName,
            "subject_name" => $request->subjectName,
            "room" => $request->room,
            "subject_code" => $request->className,
            "description" => $request->description,
        ]);
        return redirect("/");
    }
}
