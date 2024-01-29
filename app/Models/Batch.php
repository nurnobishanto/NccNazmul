<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Batch extends Model
{
    use HasFactory,SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $slug = Str::slug($model->name);
            $count = static::where('slug', $slug)->count();
            $model->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
        });
        static::updating(function ($model) {
            $slug = Str::slug($model->slug);
            $count = static::where('slug', $slug)->where('id','!=',$model->id)->count();
            $model->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
        });
    }
    public function exam_papers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ExamPaper::class);
    }
}
