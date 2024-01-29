<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $slug = Str::slug($model->title);
            $count = static::where('slug', $slug)->count();
            $model->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
        });
        static::updating(function ($model) {
            $slug = Str::slug($model->slug);
            $count = static::where('slug', $slug)->where('id','!=',$model->id)->count();
            $model->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
        });
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class,'author_id');
    }public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class,'author_id');
    }
}
