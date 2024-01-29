<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamPaper extends Model
{
    use HasFactory, SoftDeletes;
    public function subject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    public function exam_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExamCategory::class);
    }
    public function questions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Question::class,'exam_paper_questions',);
    }
    public function batch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
    public function results(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Result::class,'exam_paper_id');
    }
}
