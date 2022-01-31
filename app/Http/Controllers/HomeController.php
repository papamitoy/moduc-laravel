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
        $subject->load(["user", "enroll", "assessments",'moduleFiles']);


        $adviser = $subject->user;

        if(empty($subject->enroll->where("student_id",Auth::user()->id)->first()) && $adviser->id != Auth::user()->id){
            return abort(404);
        }

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
    public function subjectViewResponse(Request $request, $subject){


        $subject =  Subject::where("id", $subject)->first();
        $subject->load(["enroll","assessments"]);




        if(empty($subject->enroll->where("student_id",Auth::user()->id)->first())){
            return abort(404);
        }

        $assessment = $subject->assessments->where("id",$request->query("assessment_id"))->first();

        $checkResponse = $assessment->response->where("status" , "0")->where("user_id",Auth::user()->id)->first();
        $checkResponse1 = $assessment->response->where("status" , "1")->where("user_id",Auth::user()->id)->first();

        $responseSubmission = !empty($checkResponse) || !empty($checkResponse1);
        return view("pages.assessmentresponse",compact('assessment','responseSubmission'));
    }
    public function subjectCheckResponse(Request $request,$subject){
        $subject =  Subject::where("id", $subject)->where("user_id",Auth::user()->id)->first();
        if(empty($subject))return abort(404);
        $subject->load(["assessments"]);
        $assessment = $subject->assessments->where("id",$request->assessment_id)->first();
        $assessment->load(["response"]);
        $responses = $assessment->response->load(["student"]);
        $students = [];
        foreach ($responses as  $key => $value) {
            $students[$key] = $value->student;
        }

        return view("pages.checkresponse",compact('responses','students','assessment'));
    }
    public function studentGrades(Request $request ,$id){
        $subject = Subject::where("id",$id)->first();
        if(!empty($subject)){
            $subject->load(["grades","user", "enroll", "assessments",'moduleFiles','moduleSection']);
            $subject->assessments->load(["response"]);
            $subject->enroll->load("student");

            $moduleSection = ModuleSection::where("subject_id",$subject->id)->get();
            foreach($subject->enroll as $enrolled){
                $enrolled->student->load(["assessmentSubmissions","grades"]);
            }
            foreach($subject->assessments as $assessment){
                $assessment->load(["moduleSection"]);
            }

            $enrolled = $subject->enroll;
          
            return view("pages.showgrades",compact('subject','moduleSection','enrolled'));
        }
        return abort(404);
    }
}
