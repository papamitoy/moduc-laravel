<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainAssessment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();

        self::updating(function($model){
            Assessment::where("main_assessment_id",$model->id)->update([
                "title"=> $model->title,
                "type" => $model->type,
                "exam_type" => $model->exam_type,
                "description" => $model->description,
                "questions" => $model->questions,
                "max_score"=> $model->max_score,
                "shuffle" => $model->shuffle
            ]);
        });
    }
}
