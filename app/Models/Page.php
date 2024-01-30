<?php

namespace App\Models;

use Dotlogics\Grapesjs\App\Contracts\Editable;
use Dotlogics\Grapesjs\App\Traits\EditableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model implements Editable
{
    use HasFactory, EditableTrait;
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
}
