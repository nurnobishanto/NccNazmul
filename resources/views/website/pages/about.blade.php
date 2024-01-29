@extends('layouts.master')

@section('content')

    <!-- Start About US Area -->
    <div class="expertise-area-with-white-color ptb-100">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="expertise-image-wrap" data-aos="fade-left" data-aos-delay="50" data-aos-duration="500"
                         data-aos-once="true">
                        <img src="{{ asset('uploads/'.getSetting('about_page_image')) }}" alt="image">
                    </div>
                    <div class="expertise-content black-color" data-aos="fade-right" data-aos-delay="50"
                         data-aos-duration="500" data-aos-once="true">

                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-sm-6">
                                <div class="expertise-inner-box">
                                    <div class="icon">
                                        <i class="ri-thumb-up-fill"></i>
                                    </div>
                                    <h2> {!! getSetting('about_page_experience') !!}</h2>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6">
                                <div class="expertise-inner-box">
                                    <div class="icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <h2>{!! getSetting('about_page_students') !!}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="expertise-content black-color" data-aos="fade-right" data-aos-delay="50"
                         data-aos-duration="500" data-aos-once="true">
                        <span>{!! getSetting('about_page_title') !!}  </span>
                        <h3>{!! getSetting('about_page_heading') !!} </h3>
                        <p>{!! getSetting('about_page_description') !!} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Us Area -->
    <!-- Start Funfact Area -->
    <div class="fun-fact-area bg-three pt-100 pb-75" style="background-color: #004400">
        <div class="container">
            <div class="section-title">
                <span>Our Funfact</span>
                <h2>Our Resource History</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-funfact-box">
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <h3>
                            <span class="odometer" data-count="{{\App\Models\User::count()}}">00</span>
                            <span class="small-text">+</span>
                        </h3>
                        <p>Happy Students</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-funfact-box">
                        <div class="icon">
                            <i class="ri-stack-line"></i>
                        </div>
                        <h3>
                            <span class="odometer" data-count="{{\App\Models\Subject::count()}}">00</span>
                            <span class="small-text">+</span>
                        </h3>
                        <p>Total Subject</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-funfact-box">
                        <div class="icon">
                            <i class="fa fa-newspaper"></i>
                        </div>
                        <h3>
                            <span class="odometer" data-count="{{\App\Models\ExamPaper::count()}}">00</span>
                            <span class="small-text">+</span>
                        </h3>
                        <p>Total Exam Paper</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-funfact-box">
                        <div class="icon">
                            <i class="fa fa-question-circle"></i>
                        </div>
                        <h3>
                            <span class="odometer" data-count="{{\App\Models\Question::count()}}">00</span>
                            <span class="small-text">+</span>
                        </h3>
                        <p>Total Questions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Funfact Area -->

    <!-- Start Team Area -->
    <div class="team-area-without-color pt-100 pb-75">
        <div class="container">
            <div class="section-title">
                <span>Our Teachers</span>
                <h2>Meet our respected teachers</h2>
            </div>

            <div class="row justify-content-center">
                @foreach($teachers as $teacher)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-team-item card">
                            <div class="team-image">
                                 <img src="{{asset('uploads/'.$teacher->image)}}" alt="{{$teacher->name}}">
                            </div>
                            <div class="team-content text-center">
                                <h3>{{$teacher->name}}</h3>
                                <span>{{$teacher->tagline}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
    <!-- End Team Area -->
@endsection
