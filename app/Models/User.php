<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];
    protected $fillable = [
        'type',
        'fullname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdviser()
    {
        return $this->type == "adviser";
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class, "user_id", "id");
    }
    public function enroll(){
        return $this->hasMany(Enroll::class,"student_id","id");
    }

    public function assessmentSubmissions(){
        return $this->hasMany(AssessmentResponse::class,"user_id","id");
    }

    public function grades(){
        return $this->hasMany(Grade::class,"user_id");
    }

    public function notifications(){
        return $this->hasMany(Notification::class,"to");
    }
    public function notificationCount(){
        return count($this->notifications->where("seen",false));
    }

    public function mainassessments(){
        return $this->hasMany(MainAssessment::class,"user_id");
    }
}
