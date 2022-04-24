<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentFiles;
use App\Models\AssessmentResponse;
use App\Models\Grade;
use App\Models\Module;
use App\Models\ModuleSection;
use App\Models\Notification;
use App\Models\Subject;
use App\Models\SubjectFeed;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except(["uploadFileToAssessment"]);
    }
    public function createClass(Request $request)
    {
        generateCode:
        $subjectCode = mt_rand(10000000, 99999999);
        $subject =  Subject::where("subject_code", $subjectCode)->first();
        if (!empty($subject)) {
            goto generateCode;
        }


        $created = Auth::user()->subjects()->create([
            "class_name" => $request->className ? $request->className : "",
            "section_name" => $request->sectionName ? $request->sectionName : "",
            "subject_name" => $request->subjectName ? $request->subjectName : "No Subject Title",
            "room" => $request->room ? $request->room : "",
            "subject_code" => $subjectCode,
            "description" => $request->description ? $request->description : "",
        ]);

        if (!empty($created)) {

            ModuleSection::insert([
                [
                    "subject_id" => $created->id,
                    "title" => "Prelim",
                    "description" => "",
                    "order"=> 1,
                    "status" => false

                ],
                [
                    "subject_id" => $created->id,
                    "title" => "Midterm",
                    "description" => "",
                    "order"=> 2,
                    "status" => false

                ],
                [
                    "subject_id" => $created->id,
                    "title" => "Semi-final",
                    "description" => "",
                    "order"=> 3,
                    "status" => false

                ],
                [
                    "subject_id" => $created->id,
                    "title" => "Final",
                    "description" => "",
                    "order"=> 4,
                    "status" => false

                ]
            ]);
        }



        return redirect("/");
    }
    public function updateClass(Request $request)
    {
         Auth::user()->subjects()->where("id",$request->id)->update(
            [
                "class_name" => $request->className ? $request->className : "",
                "section_name" => $request->sectionName ? $request->sectionName : "",
                "subject_name" => $request->subjectName ? $request->subjectName : "No Subject Title",
                "room" => $request->room ? $request->room : "",
                "description" => $request->description ? $request->description : "",
            ]
        );
        return redirect()->route("subject.view",$request->id);
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

        $subject->load("assessments","enroll");
        if ($request->selectedId != null) {
            $selectedSubject =  $subject->assessments()->where("id", $request->selectedId)->first();
            if (!empty($selectedSubject)) {
                $selectedSubject->update([
                    'module_section_id' => $request->module_section_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'questions' => json_encode($request->questions),
                    'deadline' => $request->deadline,
                    'type' => $request->assessmentType,
                    "published" =>  $selectedSubject->published,
                    "shuffle" => $request->shuffle,
                    "exam_type" => $request->examType && $request->assessmentType == 'exam' ? $request->examType : ''
                ]);

                if (collect(json_decode($selectedSubject->questions))->count() == 0) {
                    $selectedSubject->published = false;
                    $selectedSubject->save();
                }

                return response()->json(['success' => true, 'message' => "You've successfully created a questionaire", "data" => $selectedSubject, "request" => $request->all()]);
            } else {
                return response()->json(['success' => false, 'message' => "No assessment found"]);
            }
        } else {
            $newAssessment = $subject->assessments()->create([
                'module_section_id' => $request->module_section_id,
                'title' => $request->title,
                'description' => $request->description,
                'questions' => json_encode($request->questions),
                'deadline' => isset($request->deadline) ? $request->deadline : null,
                'type' => $request->assessmentType,
                "published" => 0,
                "shuffle" => $request->shuffle,
                "exam_type" => $request->examType && $request->assessmentType == 'exam' ? $request->examType : ''
            ]);

            return response()->json(['success' => true, "reload" => true, 'message' => "You've successfully created a questionaire", "data" => $newAssessment, "request" => $request->all()]);
        }
    }

    public function getAssessment(Request $request)
    {
        $assessment = Assessment::where("id", $request->id)->first();
        if (!empty($assessment))
            return response()->json(['success' => true,  "data" => $assessment]);
        return response()->json(['success' => false]);
    }
    public function postAssessment(Request $request)
    {
        $assessment = Assessment::where("id", $request->selectedId)->first();

        if (!empty($assessment)) {
            $assessment->load("subject");
            $assessment->update([
                'title' => $request->title,
                'description' => $request->description,
                'questions' => json_encode($request->questions),
                'deadline' => $request->deadline,
                'type' => $request->assessmentType,
                "published" => $request->published,
                "shuffle" => $request->shuffle,

            ]);
            try{
                if($request->published && !$assessment->broadcasted){
                    $assessment->broadcasted = true;
                    $assessment->save();

                    SubjectFeed::create([
                    "assessment_id" => $assessment->id,
                    "subject_id" => $assessment->subject->id,
                    "title" => $assessment->title,
                    "body" => "An ".(ucfirst($request->assessmentType))." has been created.",
                    "student_link"=> "/subject/".$assessment->subject->id."/response?assessment_id=$assessment->id",
                    "adviser_link"=> "/subject/".$assessment->subject->id."/section/$assessment->module_section_id/assessment/create?u=$assessment->id",
                    "owner" => $assessment->subject-> user_id,
                    ]);

                    foreach($assessment->subject->enroll as $enroll){
                        Notification::create([
                        "from" => $assessment->subject-> user_id,
                        "to" =>$enroll-> student_id,
                        "title" => $assessment->subject->subject_name .": ".(strlen($assessment->title) > 20 ? substr($assessment->title,0,20)."..." :$assessment->title),
                        "body" => strlen($assessment->description) > 20 ? substr($assessment->description,0,20)."..." : (!empty($assessment->description) ? $assessment->description :  $assessment->subject->subject_name ." new assessment"),
                        "link" => "/subject/".$assessment->subject->id."/response?assessment_id=".$assessment->id
                    ]);


                    }
                }
            }catch(Exception $er){
                dd($er);
            }
            return response()->json(['success' => true, "redirect" => "/subject/" . $assessment->subjectId(), "data" => $assessment]);
        }
        return response()->json(['success' => false]);
    }
    public function updateSection(Request $request)
    {
        $section = ModuleSection::where("id", $request->section_id)->first();
        if (!empty($section)) {
            $section->update(['status' => $request->status]);
        }
        return response()->json(["success" => true, "data" => $section]);
    }
    function uploadFileToAssessment(Request $request)
    {
        $id = $request->query("id");
        $assessment = Assessment::where("id", $id)->first();
        if (!empty($assessment)) {
            $assessment->load(['files']);
            $name =  $request->file('fileZone')->getClientOriginalName();
            $files =  $request->file("fileZone")->store("/public/assets/uploads");
            $path = Storage::url($files);
            $assessment->files()->create([
                'name' => $name,
                "file" =>  $path
            ]);
        }
    }

    function submitResponse(Request $request){
      $assessment = Assessment::where("id",$request->id)->first();
      $assessment->load(["subject","response"]);
      $subject =  $assessment->subject->load(["enroll","user"]);
      $enroll =  $subject->enroll->where("student_id",Auth::user()->id)->first();
      if(empty($enroll) && $subject->user->id != Auth::user()->id){
          return abort(404);
      }
      $checkResponse = $assessment->response->where("status" , "0")->where("user_id",Auth::user()->id)->first();
      $checkResponse1 = $assessment->response->where("status" , "1")->where("user_id",Auth::user()->id)->first();

      if(!empty($checkResponse) || !empty($checkResponse1)){
        return response()->json(['success'=>false,"message"=>"You can only response once."]);
      }


      $create = $assessment->response()->create([
          "answers"=> $request->answers ? json_encode($request->answers) : "{}",
          "user_id" => Auth::user()->id,
        ]);
        return  response()->json(['success'=>true]);
    }

    public function saveRecord(Request $request){
        $subject = Subject::where("user_id",Auth::user()->id)->where("id",$request->subject_id)->first();
        $subject->load("assessments");
        $subject->assessments->load("response");
        $res = $subject->assessments->where("id",$request->assessment_id)->first();
        $answer = $res->response->where("id",$request->submission_id)->first();


        $answer->score =  json_encode( $request->score);
        $answer->status = 1;
        $answer->checked_by = Auth::user()->id ;
        $answer->save();
        return response()->json(["success"=>true,"data"=> $answer]);
    }
    public function uploadModule(Request $request,$subjectid,$sectionid){
        $subject = Subject::where("id",$subjectid)->first();
        if(!empty($subject) && !!$sectionid && $sectionid != 'undefined'){
            $name =  $request->file('fileZone')->getClientOriginalName();
            $files =  $request->file("fileZone")->store("/public/assets/uploads");
            $created = Module::create([
                'subject_id'=> $subject->id,
                'module_section_id'=> $sectionid,
                'title'=>'',
                'description'=>'',
                'file_name'=>$name,
                'module_file'=>$files,
                'deadline'=> Carbon::now()->addMonth(1),

            ]);
            return response()->json(['success'=>!!$created,'data'=>$created]);
        }
        return response()->json(['success'=>false]);
    }
    public function subjectFiles(Request $request){
        $subject =  Subject::where("id", $request->id)->first();
        $subject->load(["user", "enroll", "assessments",'moduleFiles']);
        return response()->json(['success'=>true,'data'=>$subject]);
    }
    public function removeAssessment(Request $request){
        $assessment = Assessment::where("id",$request->id)->first();
        if(!empty($assessment)){
            $assessment->delete();
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);
    }
    public function saveGrades(Request $request){
        $subject =  Subject::where("id", $request->subject_id)->first();
        $user = User::where("id", $request->user_id)->first();
        if(!empty($subject) && !empty($user)){
         $grade=   Grade::where([
                'subject_id' => $subject->id,
                'user_id' => $user->id,
                'module_section' => $request->module_section
            ])->first();
         if($grade){
             $grade->grades = $request->grade;
             $grade->remarks = $request->remarks;
             $grade->save();
         }else{
            $grade=   Grade::create([
                'subject_id' => $subject->id,
                'user_id' => $user->id,
                'module_section' => $request->module_section,
                'grades'=>$request->grade,
                'remarks'=>$request->remarks,
            ]);
         }
         return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);

    }
}
