<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
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
            "subject_code" => $subjectCode,
            "description" => $request->description,
        ]);
        return redirect("/");
    }
    public function joinClass(Request $request)
    {
        $this->validate($request, [
            'subject_code' => 'required'
        ]);

        $subject = Subject::where("subject_code", $request->subject_code)->first();
        if (empty($subject)) return response()->json(['success' => false, "message" => "No Subject found"]);
        $enrolled =  Auth::user()->enroll()->create([
            "subject_id" => $subject->id
        ]);
        if (empty($enrolled)) return response()->json(['success' => false, "message" => "Failed to enroll"]);

        return response()->json(['success' => true, "message" => "Enrolled Successfully"]);
    }
    public function createAssessment(Request $request)
    {
        $subject =   Subject::where("id", $request->id)->first();
        if (empty($subject)) return response()->json(['success' => false, "message" => "No Subject found"]);

        $subject->load("assessments");

        $subject->assessments()->create([
            'title' => $request->title,
            'description' => $request->description,
            'questions' => json_encode($request->questions),
            'deadline' => $request->deadline,
            'type' => $request->assessmentType
        ]);
        return response()->json(['success' => true, 'message' => "You've successfully created a questionaire"]);
    }
}
