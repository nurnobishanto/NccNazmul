<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
        public function __construct() {


        $categories = Category::All();
        $poularpost = Post::orderBy('view_count','DESC')->where('status','=','PUBLISHED')->take(6)->get();

        \View::share('allcategories', $categories);

        \View::share('poularpost', $poularpost);

    }
}
