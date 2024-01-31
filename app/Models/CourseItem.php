<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'course_module_id', 'title', 'details',
        'video', 'image', 'file', 'exam_paper_id',
        'youtube_video', 'url', 'youtube_playlist', 'pdf',
        'status', 'published_at','order'
    ];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }
    public function exam_paper()
    {
        return $this->belongsTo(ExamPaper::class, 'exam_paper_id');
    }
}
