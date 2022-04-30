<?php

namespace App\Http\Controllers;

use App\Models\MainAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function assessmentList(){
        $user = Auth::user()->load(['mainassessments','subjects']);
        $subjects = $user->subjects;
        $mainassessments = $user->mainassessments;
        return view("pages.myassessments",compact('mainassessments','subjects'));
    }
    public function createAssessment(Request $request)
    {
        return view("pages.createassessment");
    }

    public function createMyAssessment(Request $request)
    {
        $mainassessment = Auth::user()->mainassessments()->where("id",$request->selectedId)->first();
        if(empty( $mainassessment)){
            $newAssessment = Auth::user()->mainassessments()->create([
                'title' => $request->title,
                'type' => $request->assessmentType,
                'description' => $request->description,
                'questions' => json_encode($request->questions),
                'max_score' => $request->max_score ? $request->max_score: 10 ,
                'shuffle' => $request->shuffle,
                "exam_type" => $request->examType && $request->assessmentType == 'exam' ? $request->examType : ''
            ]);
            return response()->json(['success' => true, "reload" => true, 'message' => "You've successfully created a questionaire", "data" => $newAssessment, "request" => $request->all()]);
        }else{
            $newAssessment = Auth::user()->mainassessments()->updateOrCreate(
                ['id'=>$request->selectedId],
                [
                'title' => $request->title,
                'type' => $request->assessmentType,
                'description' => $request->description,
                'questions' => json_encode($request->questions),
                'max_score' => $request->max_score ? $request->max_score: 10 ,
                'shuffle' => $request->shuffle,
                "exam_type" => $request->examType && $request->assessmentType == 'exam' ? $request->examType : ''
            ]);
            return response()->json(['success' => true, "reload" => true, 'message' => "You've successfully created a questionaire", "data" => $newAssessment, "request" => $request->all()]);
        }
    }

    public function removeAssessment(Request $request){
        $assessment = MainAssessment::where("id",$request->id)->first();
        if(!empty($assessment)){
            $assessment->delete();
            return response()->json(['success'=>true,"data"=>$assessment]);
        }
        return response()->json(['success'=>false]);
    }

    public function sendAssessment(Request $request){

        $mainassessment = MainAssessment::where("id",$request->assessment_id)->first();
        if(!empty($mainassessment)){
            $subject = auth()->user()->subjects()->where("id",$request->selected_subject['id'])->first();
            $moduleSection =  $subject->moduleSection()->where("title",$request->selected_section)->first();
            if(!empty($subject) && !empty($moduleSection)){
                $assessment = $subject->assessments()->where("main_assessment_id",$mainassessment->id)->first();
                if(empty($assessment)){
                    $create = $subject->assessments()->create([
                        'module_section_id' => $moduleSection->id,
                        'title' => $mainassessment->title,
                        'description' => $mainassessment->description,
                        'questions' => $mainassessment->questions,
                        'deadline' => isset($request->deadline) ? $request->deadline : null,
                        'type' => $mainassessment->type,
                        "published" => 0,
                        "shuffle" => $mainassessment->shuffle,
                        "exam_type" => $mainassessment->exam_type,
                        "main_assessment_id" => $mainassessment->id
                    ]);
                    return response()->json(["success"=>!!$create]);
                }else{
                    return response()->json(["success"=>false,"message"=>"This Assessment is already added to this subject"]);
                }
            }
            return response()->json(["success"=>false]);

        }
    }

    public function updateAssessment(Request $request){
        $mainassessment = auth()->user()->mainassessments()->where("id",$request->query("id"))->first();
        if(empty($mainassessment)) return abort(404);
        return view("pages.updatemainassessment",compact("mainassessment"));
    }
    public function getAssessment(Request $request)
    {
        $assessment = MainAssessment::where("id", $request->id)->first();
        if (!empty($assessment))
            return response()->json(['success' => true,  "data" => $assessment]);
        return response()->json(['success' => false]);
    }
}
