<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use TCG\Voyager\Events\MenuDisplay;
use TCG\Voyager\Facades\Voyager;

class Menu extends Model
{
    use HasFactory , SoftDeletes;
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
    public function menu_items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function parent_items()
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id');
    }
    public static function display($menuName, $type = null, array $options = [])
    {
        $menu = static::where('slug', $menuName)
            ->with(['parent_items.children' => function ($q) {
                $q->orderBy('order');
            }])
            ->first();

        // Check for Menu Existence
        if (!isset($menu)) {
            return false;
        }

        $items = $menu->parent_items->sortBy('order');


        $type = $type ?? 'fallback_menu';
        $type = (!view()->exists($type)) ? 'fallback_menu' : $type;


        return new \Illuminate\Support\HtmlString(
            \Illuminate\Support\Facades\View::make($type, ['items' => $items, 'options' => $options])->render()
        );
    }
}
