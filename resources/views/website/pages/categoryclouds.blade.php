@extends('layouts.master')

@section('content')
       <!-- Start Page Banner Area -->
        <div class="page-banner-area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col">
                        <div class="page-banner-content" data-aos="fade-right" data-aos-delay="50" data-aos-duration="500" data-aos-once="true">
                            <h2>{{  ('Category Clouds')}}</h2>
        
                            <ul>
                                <li>
                                    <a href="{{Route('website')}}">Home</a>
                                </li>
                                <li>Categories</li>
                            </ul>
                        </div>
                    </div>

               
                </div>
            </div>
        </div>
        <!-- End Page Banner Area -->
        
        <!-- Start Blog Area -->
        <div class="blog-area ptb-100">
            <div class="container ">
                <div class="row">
                    <div class="col-lg-8 col-md-12">                
                        <div class="widget-area">                    
                            <div class="widget widget_tag">
                                <h3 class="widget-title">{{  ('Category Clouds')}}</h3>
                                
                                <ul class="tag-list">
                                    @foreach ($allcategories as $category)
                                    <li><a href="{{Route('website.category',['slug'=>$category->slug])}}">{{  ($category->name)}} (<span>{{$category->posts->count()}}</span>)</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>                       
                    </div>
                     @include('include.sidebar')
                </div>
            </div>
        </div>
        <!-- End Blog Area -->
        @endsection