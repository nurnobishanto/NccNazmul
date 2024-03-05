<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Dotlogics\Grapesjs\App\Traits\EditorTrait;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
class PageController extends Controller
{
    use EditorTrait;
    public function editor(Request $request, Page $page)
    {
        return $this->show_gjs_editor($request, $page);
    }
    public function view_page($slug)
    {
        $page = Page::where('slug',$slug)->first();
        if ($page){
            SEOTools::setTitle($page->title);
            SEOTools::setDescription(getSetting('site_description'));
            return view('website.pages.custom_page',compact(['page']));
        }else{
            return view('website.pages.404');
        }

    }
}
