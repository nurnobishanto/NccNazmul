<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('children');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function parent()
    {
        return $this->belongsTo(MenuItem::class)->where('id', '!=', $this->id);
    }

}
