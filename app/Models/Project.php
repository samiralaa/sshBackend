<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = [
        'name',
        'description',
        'images',
        'company',
        'location',
        'start_date',
        'end_date',
        'status',
        'type',
        'link',
    ];

    public $translatable = [
        'name',
        'description',
        'company',
        'location',
        'status',
        'type',
    ];
    public function projectTeacnologes() // Corrected to camelCase
    {
        return $this->hasMany(ProjectTeacnolagy::class, 'project_id');
    }
}
