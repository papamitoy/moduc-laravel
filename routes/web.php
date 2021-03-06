<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [HomeController::class, "homeView"])->name("home");

Route::middleware("auth")->group(function(){
    Route::middleware(['adviser'])->group(function(){
        Route::get("/subject/{subject}/section/{section}/assessment/update", [HomeController::class, "updateAssessment"])->name("subject.create.assessment");

        Route::get("/subject/{id}/assessment/check-response", [HomeController::class, "subjectCheckResponse"])->name("check.responses");
        Route::get("/subject/{id}/grades",[HomeController::class,"studentGrades"]);
        Route::post("/api/class/create", [ClassController::class, "createClass"]);
        Route::post("/api/class/update", [ClassController::class, "updateClass"]);
        Route::post("/api/class/create/assessment", [ClassController::class, "updateAssessment"]);
        Route::post("/api/class/remove/assessment", [ClassController::class, "removeAssessment"]);
        Route::post("/api/assessment/save/record",[ClassController::class,"saveRecord"]);
        Route::post("/api/update-section", [ClassController::class, "updateSection"]);
        Route::post("/subject/{id}/save-grades",[ClassController::class,"saveGrades"]);
        Route::post("/api/get/assessment", [ClassController::class, "getAssessment"]);


        Route::post("/api/assessment", [AssessmentController::class, "getAssessment"]);
        Route::post("/api/assessment/remove",[AssessmentController::class,"removeAssessment"]);
        Route::post("/api/assessment/create", [AssessmentController::class, "createMyAssessment"]);
        Route::post("/api/assessment/send", [AssessmentController::class, "sendAssessment"]);
        Route::post("/api/assessment/allowedresponse", [AssessmentController::class, "allowedResponse"]);
        Route::post("/api/assessment/showresults", [AssessmentController::class, "showResults"]);
        Route::get("/assessments",[AssessmentController::class,"assessmentList"])->name("myassessment");
        Route::get("/assessments/create",[AssessmentController::class,"createAssessment"])->name("create.myassessment");
        Route::get("/assessments/update",[AssessmentController::class,"updateAssessment"])->name("update.myassessment");

        Route::post("/api/subject/removestudent",[ClassController::class,"removeStudent"]);
    });

    Route::get("/subject/{subject}/section/{section}/assessment/view", [HomeController::class, "viewAssessment"]);
    Route::get("/subject/{id}", [HomeController::class, "subjectView"])->name("subject.view");
    Route::get("/subject/{id}/response", [HomeController::class, "subjectViewResponse"])->name("student.response");




    Route::post("/api/class/join", [ClassController::class, "joinClass"]);
    Route::post("/api/assessment/response",[ClassController::class,"submitResponse"]);
    Route::post("/upload/module-section/{id}/{secid}",[ClassController::class,"uploadModule"]);
    Route::post("/subject/{id}/files",[ClassController::class,"subjectFiles"]);

    Route::get("/notify-redirect",[HomeController::class,"notifyClick"]);

    Route::post("/api/response/time-expended",[ClassController::class,"getTimeExpended"]);
    Route::post("/api/response/time-save",[ClassController::class,"saveTimeExpended"]);
});




Route::get('/login', [LoginController::class, "authView"])->name("login");
Route::post("/login", [LoginController::class, "loginAttempt"]);
Route::post("/register", [LoginController::class, "register"]);
Route::get("/logout", [LoginController::class, "logout"]);
