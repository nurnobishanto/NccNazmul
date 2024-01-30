@extends('layouts.master')

@section('content')
    <!-- Start Main Hero Area -->
    @include('website.includes.home_hero')
    <!-- End Main Hero Area -->
    <div class="statistics-wrap ">
        <div class="container">
            <div class="row small t-ctr mt0">
                <div class="col-lg-3 col-sm-6">
                    <div class="statistics">
                        <div class="statistics-img">
                            <img src="{{asset('website')}}/images/icons/deal.svg" alt="happy" class="img-fluid">
                        </div>
                        <div class="statnumb">
                            <span class="counter">{{\App\Models\User::count()}}</span>
                            <p>Happy Students</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="statistics">
                        <div class="statistics-img">
                            <img src="{{asset('website')}}/images/icons/computers.svg" alt="project" class="img-fluid">
                        </div>
                        <div class="statnumb counter-number">
                            <span class="counter">{{\App\Models\Subject::count()}}</span>
                            <p>Total Subject</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="statistics">
                        <div class="statistics-img">
                            <img src="{{asset('website')}}/images/icons/worker.svg" alt="work" class="img-fluid">
                        </div>
                        <div class="statnumb">
                            <span class="counter">{{\App\Models\ExamPaper::count()}}</span>
                            <p>Total Exam Paper</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="statistics mb0">
                        <div class="statistics-img">
                            <img src="{{asset('website')}}/images/icons/customer-service.svg" alt="support" class="img-fluid">
                        </div>
                        <div class="statnumb">
                            <span class="counter">{{\App\Models\Question::count()}}</span>
                            <p>Total Questions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="work-category  pad-tb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="common-heading ptag">
                        <h2>Course Category</h2>
                    </div>
                </div>
            </div>
            <div class="row mt30">
                @foreach(getCourseCategories() as $category)
                    <div class="col-lg-4 col-sm-6 col-6 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                        <a href="">
                            <div class="industry-workfor hoshd">
                                @if($category->image)
                                <img src="{{asset('uploads/'.$category->image)}}" alt="{{$category->title}}">
                                @endif
                                <h6>{{$category->title}}</h6>
                            </div>
                        </a>
                    </div>
                @endforeach
        </div>
    </section>
@endsection
