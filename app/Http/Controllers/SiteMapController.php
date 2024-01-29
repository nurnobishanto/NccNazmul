<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subject;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function generateSitemap(){
        $posts = Post::orderBy('updated_at', 'desc')->get();
        $subjects = Subject::orderBy('updated_at', 'desc')->get();
        $sitemap = resolve("sitemap");
        $sitemap->add(route('website'), now(), '1.0','daily');
        $sitemap->add(route('website.contact'), now(), '0.99','daily');
        $sitemap->add(route('website.about'), now(), '0.98','daily');
        $sitemap->add(route('blog'), now(), '0.95','daily');
        $sitemap->add(route('exam'), now(), '0.97','daily');
        $sitemap->add(route('ebook'), now(), '0.96','daily');
        $sitemap->add(route('notes'), now(), '0.94','daily');
        $sitemap->add(route('website.category_clouds'), now(), '0.93','daily');
        $sitemap->add(route('login'), now(), '0.8', 'monthly');
        $sitemap->add(route('register'), now(), '0.8', 'monthly');


        foreach ($posts as $post) {
            $sitemap->add(route('website.post',['slug' => $post->slug]), $post->updated_at, '0.9', 'monthly');
        }
        foreach ($subjects as $subject){
            $sitemap->add(route('subject',['slug' => $subject->slug]), $subject->updated_at, '0.89', 'daily');
            $categories = $subject->exam_categories;
            foreach ($categories as $category){
                $sitemap->add(route('exam_category',['slug' => $category->slug]), $category->updated_at, '0.88', 'daily');
                $exams = $category->exam_papers;
                foreach ($exams as $exam){
                    $sitemap->add(route('start',['id' => $exam->id]), $exam->updated_at, '0.87', 'daily');
                }
            }
        }

        $sitemap->store('xml', 'sitemap');
        return redirect('/sitemap.xml');
    }
}
