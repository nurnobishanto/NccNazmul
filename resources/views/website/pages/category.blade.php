@extends('layouts.master')

@section('content')
       <!-- Start Page Banner Area -->
        <div class="page-banner-area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col">
                        <div class="page-banner-content" data-aos="fade-right" data-aos-delay="50" data-aos-duration="500" data-aos-once="true">
                            <h2>{{$category->name}}</h2>

                            <ul>
                                <li><a href="{{Route('website')}}">Home</a></li>
                                <li><a href="{{Route('website.category_clouds')}}">Category</a></li>
                                <li>{{$category->name}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Banner Area -->

        <!-- Start Blog Area -->
        <div class="blog-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                         <div class="row justify-content-center">
                        @if ($categoryposts->count()==0)

                           <h2 class="text-center text-danger">No Post Found</h2>

                           @else



                            @foreach ($categoryposts as $post)
                             <div class="col-lg-6 col-md-6">
                                <div class="single-blog-card">
                                    <div class="blog-image">

                                        @if ( $post->image )
                                            <a href="{{Route('website.post',['slug'=>$post->slug])}}"><img src="{{ asset( 'uploads/'.$post->image )}}" alt="{{$post->title}}"></a>
                                        @else
                                        <a href="{{Route('website.post',['slug'=>$post->slug])}}">
                                            <img src="{{ asset('website') }}/assets/images/blog/blog-1.jpg" alt="{{$post->title}}"></a>
                                        @endif


                                    </div>
                                    <div class="blog-content with-padding">
                                        @if ($post->user)
                                            <span>By <a href="{{Route('website.author',['slug'=>$post->user->id])}}">{{$post->user->name}}</a></span>
                                        @else

                                        @endif

                                        <h3>
                                            <a href="{{Route('website.post',['slug'=>$post->slug])}}">{{$post->title}}</a>
                                        </h3>
                                        @if (strlen($post->excerpt)!=0)
                                            <p>{{Str::limit( $post->excerpt), 100, ' ...'; }}</p>
                                        @else
                                            <p>{{ Str::limit( strip_tags($post->body)), 100, ' ...';}}</p>
                                        @endif



                                        <ul class="entry-meta">
                                            <li><i class="ri-calendar-line"></i> {{$post->created_at->format('M d, Y')}}</li>
                                            @if ($post->category)
                                                <li><i class="ri-price-tag-3-line"></i> <a href="{{Route('website.category',['slug'=>$post->category->slug])}}">{{$post->category->name}}</a></li>
                                            @endif
                                            <li>
                                                <i class="ri-eye-line"></i>
                                                @if ($post->view_count<1000)
                                                    {{ $post->view_count }}
                                                @else
                                                    @php
                                                        $count = $post->view_count/1000;
                                                    @endphp
                                                      @if ($count<100)
                                                      {{round($count, 2)}}K
                                                      @else
                                                        @php
                                                            $countm = $count/1000;
                                                          @endphp
                                                         {{round($countm, 2)}}M
                                                      @endif

                                                @endif

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                            <span>{{$categoryposts->count()}} Posts Found</span>
                          @endif
                        </div>

                        {{ $categoryposts->links('vendor.pagination.custom') }}


                    </div>

            {{-- Sidebar --}}
           @include('include.sidebar')
                </div>
            </div>
        </div>
        <!-- End Blog Area -->
        @endsection
