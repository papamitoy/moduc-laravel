<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectFeed extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function assessment(){
        return $this->belongsTo(Assessment::class,"assessment_id");
    }
}
