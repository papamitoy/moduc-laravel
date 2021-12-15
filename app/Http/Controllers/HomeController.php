<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\ModuleSection;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function homeView()
    {
        $enrolled = Auth::user()->enroll->load("subject");
        return view("pages.home", compact('enrolled'));
    }
    public function subjectView(Request $request, $subject)
    {
        $subject =  Subject::where("id", $subject)->first();
        $subject->load(["user", "enroll", "assessments"]);
        $adviser = $subject->user;


        $students = $subject->enroll->load("student");

        $moduleSection =  ModuleSection::where("subject_id", $subject->id)->get();
        $moduleSection->load(['assessments']);
        foreach ($moduleSection as $section) {
            $section->assessments->load(['files']);
        }
        return view("pages.subject", compact('subject', 'adviser', 'students', "moduleSection"));
    }
    public function createAssessment(Request $request, Subject $subject, ModuleSection $section)
    {

        $create =  $request->query("u");
        if (!$create) {
            $assessment = $subject->assessments()->create([
                'module_section_id' => $section->id,
                'title' => "Untitled Form",
                'description' => "",
                'questions' => "[]",
                'deadline' =>  null,
                'type' => "assessment",
                "published" => 0,
                "shuffle" => false
            ]);
            return redirect("/subject/$subject->id/section/$section->id/assessment/create?u=$assessment->id");
        }
        // if($create == "new"){
        //     redirect()
        // }
        return view("pages.createassesment", compact('subject', "section"));
    }
    public function viewAssessment(Request $request, Subject $subject)
    {
        $subject->load(["assessments"]);
    }
}
