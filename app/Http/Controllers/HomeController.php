<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Grade;
use App\Models\ModuleSection;
use App\Models\Subject;
use Astatroth\LaravelTimer\Timer;
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
            foreach($enrolled as $value){
                $value->subject->load('user');
            }


        return view("pages.home", compact('enrolled'));
    }
    public function subjectView(Request $request, $subject)
    {
        $subject =  Subject::where("id", $subject)->first();
        if(empty($subject)) return abort(404);
        $subject->load(["user", "enroll", "assessments",'moduleFiles']);
        $assessments = $subject->assessments()->upcomming()->get();

        $adviser = $subject->user;

        if(empty($subject->enroll->where("student_id",Auth::user()->id)->first()) && $adviser->id != Auth::user()->id){
            return abort(404);
        }

        $students = $subject->enroll->load("student");
        $moduleSection =  ModuleSection::where("subject_id", $subject->id)->orderBy("order","asc")->get();
        $moduleSection->load(['assessments']);
        foreach ($moduleSection as $section) {
            $section->assessments->load(['files','response']);
        }
        $grades = Grade::where("subject_id",$subject->id)->get();
        $grades->load(["subject","student"]);
        $feeds = $subject->feeds()->orderBy("id","desc")->get();

        return view("pages.subject", compact('feeds','assessments','subject', 'adviser', 'students', "moduleSection","grades"));
    }
    public function updateAssessment(Request $request, Subject $subject, ModuleSection $section)
    {
        $create =  $request->query("u");
        if ($create) {
            $assessment = auth()->user()->subjects()->where("id",$subject->id)->first()->assessments()->where("id",$create)->first();

            return view("pages.updateassesment", compact('subject', "section",'assessment'));
        }
        return abort(404);
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

        if($assessment->shuffle){
            $assessment->questions = json_encode(collect(json_decode($assessment->questions))->shuffle());
        }

        $timeExpended = auth()->user()->answerTimeLimits()->where("assessment_id",$assessment->id)->first();


        return view("pages.assessmentresponse",compact('assessment','responseSubmission','subject','timeExpended'));
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

        return view("pages.checkresponse",compact('responses','students','assessment','subject'));
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

    function notifyClick(){
        Auth::user()->notifications->where("id",request()->query("id"))->first()->update([
            'seen' => true,
        ]);
        return redirect(request()->query("url"));
    }

    function getEquiv(){
        return [
            4.0,
            3.9,
            3.9,
            3.9,
            3.9,
            3.9,
            3.9,
            3.9,
            3.9,
            3.9,
            3.9,
            3.8,
            3.8,
            3.8,
            3.8,
            3.8,
            3.8,
            3.8,
            3.8,
            3.8,
            3.7,
            3.7,
            3.7,
            3.7,
            3.7,
            3.6,
            3.6,
            3.6,
            3.6,
            3.6,
            3.5,
            3.5,
            3.5,
            3.5,
            3.5,
            3.4,
            3.4,
            3.4,
            3.4,
            3.4,
            3.3,
            3.3,
            3.3,
            3.3,
            3.3,
            3.2,
            3.2,
            3.2,
            3.2,
            3.2,
            3.1,
            3.1,
            3.1,
            3.1,
            3.1,
            3.1,
            3.1,
            3.1,
            3.1,
            3.1,
            3.0,
            2.9,
            2.9,
            2.9,
            2.8,
            2.8,
            2.7,
            2.7,
            2.6,
            2.6,
            2.5,
            2.5,
            2.4,
            2.4,
            2.3,
            2.3,
            2.2,
            2.2,
            2.1,
            2.1,
            2.0,
            2.0,
            1.9,
            1.9,
            1.8,
            1.8,
            1.7,
            1.7,
            1.6,
            1.6,
            1.5,
            1.5,
            1.4,
            1.4,
            1.3,
            1.3,
            1.2,
            1.2,
            1.1,
            1.1,
            1.0,

            ];
    }
}
