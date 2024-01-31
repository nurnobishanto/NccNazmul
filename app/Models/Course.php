<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'meet_link', 'whatsapp_group_link', 'details', 'facebook_group','order',
        'zoom_link', 'youtube_playlist', 'course_category_id','duration','image',
        'regular_price', 'sale_price', 'start_date', 'publish_date','featured',
        'end_date', 'expired_date', 'status', 'lifetime_access','slug','title'
    ];
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
    public function modules()
    {
        return $this->hasMany(CourseModule::class);
    }
    public function items()
    {
        return $this->hasMany(CourseItem::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,)->withPivot('lifetime_access', 'access_expiry');
    }
}
