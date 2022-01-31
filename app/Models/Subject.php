<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
    public function enroll()
    {
        return $this->hasMany(Enroll::class, "subject_id", "id");
    }
    public function assessments()
    {
        return $this->hasMany(Assessment::class, "subject_id", "id");
    }
    public function moduleSection()
    {
        return $this->hasMany(ModuleSection::class, "subject_id", "id");
    }
    public function moduleFiles(){
        return $this->hasMany(Module::class,"subject_id","id");
    }
    public function grades(){
        return $this->hasMany(Grade::class,"subject_id","id");
    }
}
