<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseModule extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'course_id', 'title', 'description','order'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function items()
    {
        return $this->hasMany(CourseItem::class, 'course_module_id');
    }
}
