<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    public function enroll(){
        return $this->hasMany(Enroll::class,"subject_id","id");
    }
}
