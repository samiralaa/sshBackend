<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTeacnolagy extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'technology'];

    // Define relationships if needed
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
