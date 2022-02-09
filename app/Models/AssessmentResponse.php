<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResponse extends Model
{
    use HasFactory;
    protected $table = 'assessment_submissions';
    protected $guarded = [];

    public function student(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function assessment(){
        return $this->belongsTo(Assessment::class,"assessment_id","id");
    }
}
