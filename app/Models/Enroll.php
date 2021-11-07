<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subject(){
        return $this->belongsTo(Subject::class,"subject_id","id");
    }

    public function student(){
        return $this->belongsTo(User::class,"student_id","id");
    }
}
