@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'Categories','url'=>'#'])


        <!-- Start Blog Area -->
        <div class="blog-area pad-tb">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="recent-post widgets mt60">
                            <h3 class="mb30">Categories</h3>
                            <div class="tabs">
                                @foreach (getAllCategories() as $category)
                                    <a href="{{route('website.category',['slug'=>$category->slug])}}" class="text-capitalize">{{  $category->name}} (<span>{{$category->posts->count()}})</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                     @include('website.includes.blog_sidebar')
                </div>
            </div>
        </div>
        <!-- End Blog Area -->
        @endsection
