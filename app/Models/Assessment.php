<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $table = 'assessments';
    protected $guarded = [];
    public function subjectId()
    {
        return $this->subject->id;
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, "subject_id", "id");
    }
    public function module()
    {
        return $this->belongsTo(ModuleSection::class, "module_section_id", "id");
    }
    public function files()
    {
        return $this->hasMany(AssessmentFiles::class, "assessment_id", "id");
    }
    public function response(){
        return $this->hasMany(AssessmentResponse::class,"assessment_id","id");
    }

    public function moduleSection(){
        return $this->belongsTo(ModuleSection::class,"module_section_id","id");
    }

    public function scopeUpcomming($query){
        return $query->whereDate("deadline",">",Carbon::now())->where("published",true);
    }
}
