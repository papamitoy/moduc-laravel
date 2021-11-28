<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleSection extends Model
{
    use HasFactory;
    protected $table = "module_section";
    protected $guarded = [];

    public function getFiles()
    {
        return $this->assessments()->load(['files']);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class, "module_section_id", "id");
    }
}
