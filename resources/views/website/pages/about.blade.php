@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'About US','url'=>'#'])
    <!--Start About-->
    <section class="about-agency pad-tb block-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 v-center">
                    <div class="about-image">
                        <img src="{{ asset('uploads/'.getSetting('about_page_image')) }}" alt="about us" class="img-fluid"/>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="common-heading text-l ">
                        <span>{!! getSetting('about_page_title') !!} </span>
                        <h2>{!! getSetting('about_page_heading') !!}</h2>
                        <p>{!! getSetting('about_page_description') !!}</p>
                    </div>
                    <div class="row in-stats small about-statistics">
                        <div class="col-lg-4 col-sm-4">
                            <div class="statistics">
                                <div class="statnumb counter-number">
                                    <span class="counter">{{\App\Models\User::count()}}</span>
                                    <p>Happy Students</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="statistics">
                                <div class="statnumb">
                                    <span class="counter">{{\App\Models\Subject::count()}}</span>
                                    <p>Total Subjects</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="statistics mb0">
                                <div class="statnumb counter-number">
                                    <span class="counter">{{\App\Models\ExamPaper::count()}}</span>
                                    <p>Total Exam Paper</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End About-->
    @if($teachers->count())
    <!--Start Team Members-->
    <section class="team pad-tb deep-dark">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="common-heading ptag">
                        <span>Our Teachers</span>
                        <h2>Meet our respected teachers</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($teachers as $teacher)
                <div class="col-lg-3 col-sm-6">
                    <div class="full-image-card hover-scale">
                        <div class="image-div"><a href="#"><img src="{{asset('uploads/'.$teacher->image)}}" alt="team" class="{{$teacher->name}}"/></a></div>
                        <div class="info-text-block">
                            <h4><a href="#">{{$teacher->name}}</a></h4>
                            <p>{{$teacher->tagline}}</p>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </section>
    <!--End Team Members-->
    @endif


@endsection
