@extends('layouts.master')

@section('content')
    <!-- Start Main Hero Area -->

    <div class="main-banner-wrap-area">
        <div class="container">
            @if(getSetting('update_headline'))
            <div class="mb-5 bg-secondary">
                <h6 style="z-index: 5" class="p-2 position-absolute rounded bg-danger text-light" >Headline</h6>
                <marquee class="text-light" style="font-size: 18px;line-height: 28px">{!! getSetting('update_headline') !!}</marquee>

            </div>
            @endif
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="main-banner-wrap-content" data-speed="0.05" data-revert="true">
                        @if(getSetting('site_tagline'))
                            <span data-aos="fade-right" data-aos-delay="50" data-aos-duration="500" data-aos-once="true">{!! getSetting('site_tagline') !!}</span>
                        @endif
                        <h1 data-aos="fade-right" data-aos-delay="70" data-aos-duration="700" data-aos-once="true">{!! getSetting('home_page_title') !!}  </h1>
                        <p data-aos="fade-right" data-aos-delay="580" data-aos-duration="800" data-aos-once="true">{!! getSetting('home_page_description')  !!} </p>

                        <div class="banner-btn" data-aos="fade-right" data-aos-delay="90" data-aos-duration="900" data-aos-once="true">
                            <a href="{{ route('exam') }}" class="default-btn">Take Exam</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12" data-aos="fade-left" data-aos-delay="50" data-aos-duration="500" data-aos-once="true">
                    <div class="main-banner-wrap-image" data-speed="0.05" data-revert="true">
                        <img src="{{asset('uploads/'.getSetting('home_page_background'))}}">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Hero Area -->

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

    <!-- Start Services Area -->
    <div class="services-area bg-F9F5F4 pt-100 pb-75">
        <div class="container">
            <div class="section-title">
                <span>Our Services</span>
                <h2>What We Offer</h2>
                <p>আমরা Easy English পরিবার এতটুকু কথা দিতে পারি যে, কোনো স্টুডেন্ট যদি SSC থেকেই আমাদের সাথে লেগে থাকে তাহলে ইংশা আল্লাহ সে ‍SSC- তে Golden A+ & HSC- তে Golden A+ & Admission এ যেকোনো একটা পাবলিক বিশ্ববিদ্যালয়ে চান্স পাবেই পাবে। ইংশা আল্লাহ।</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single-services-box">
                        <div class="icon">
                            <i class="fab fa-skyatlas"></i>
                        </div>
                        <h3>
                            <a href="">HSC BATCH</a>
                        </h3>
                        <p>HSC এর সকল বিভাগের Bangla, English & ICT আর কমার্স এর সকল বিষয়  । আমরা সমস্ত সাবজেক্ট একদম বেসিক থেকে গড়ে উঠাই যার দ্বারা HSC-তে ভালো রেজাল্ট এবং ভার্সিটিতে চান্স পাওয়ার ক্ষেত্রে অনেকাংশে এগিয়ে থাকবা ।</p>
                        <div class="back-icon">
                            <i class="fab fa-skyatlas"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services-box">
                        <div class="icon">
                            <i class="ri-code-line"></i>
                        </div>
                        <h3>
                            <a href="">SSC Batch</a>
                        </h3>
                        <p>একদম SSC Level থেকে গড়ে তোলার জন্য আমাদের রয়েছে SSC Special Batch. যেখানে আমরা একদম শূন্য থেকে তোমাকে গড়ে তুলবো যার মাধ্যমে SSC তে পাবে Golden A+.বেসিক ক্লিয়ার থাকার কারণে মজা উপভোগ করবা HSC তে ।
                        </p>
                        <div class="back-icon">
                            <i class="ri-code-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-services-box">
                        <div class="icon">
                            <i class="fas fa-diagnoses"></i>
                        </div>
                        <h3>
                            <a href="">ONLINE EXAM</a>
                        </h3>
                        <p>আমাদের রয়েছে প্রতিটি সাবজেক্ট এর প্রতিটি অধ্যায়ের উপর পরীক্ষা । আর এই সমস্ত পরীক্ষা তুমি বার বার দেওয়ার মাধ্যমে নিজেকে বোর্ড পরীক্ষার উপযোগী করে তুলতে পারবা ।</p>
                        <div class="back-icon">
                            <i class="fas fa-diagnoses"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-services-box">
                        <div class="icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>
                            <a href="">HSC Special Batch</a>
                        </h3>
                        <p>HSC বোর্ড পরীক্ষার শেষ মুহূর্তের বিশেষ প্রস্তুতির জন্য আমাদের থাকবে বোর্ড পরীক্ষা ৩ মাস পূর্বে  Test Paper & Model Test Solved course.</p>
                        <div class="back-icon">
                            <i class="fas fa-award"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-services-box">
                        <div class="icon">
                            <i class="fab fa-wpforms"></i>
                        </div>
                        <h3>
                            <a href="">Admission Batch</a>
                        </h3>
                        <p>ঢাকা বিশ্ববিদ্যালয় সহ যেকোনো পাবলিক বিশ্ববিদ্যালয়ের ভর্তির যুদ্ধে তোমাকে প্রস্তুত করার জন্য আমাদের রয়েছে (B-মানবিক), (C-কমার্স) Unit এর পূর্ণাঙ্গ কোর্স.</p>
                        <div class="back-icon">
                            <i class="fab fa-wpforms"></i>
                        </div>
                    </div>
                </div>



                <div class="col-lg-4 col-md-6">
                    <div class="single-services-box">
                        <div class="icon">
                            <i class="fab fa-hive"></i>
                        </div>
                        <h3>
                            <a href="">Special English Batch</a>
                        </h3>
                        <p>তুমি যদি আমাদের কাছে শুধু English সাবজেক্টটি পরতে চাও তার ব্যবস্থাও রয়েছে</p>
                        <div class="back-icon">
                            <i class="fab fa-hive"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Services Area -->

    <!-- Start Why Choose Us Area -->
    <div class="why-choose-us-area-with-video ptb-100">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="why-choose-us-video-view" data-speed="0.09" data-revert="true">
                        <a href="https://www.youtube.com/watch?v=Bi3-cftfb9s" class="video-btn popup-youtube">
                            <i class="flaticon-play-button"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="why-choose-us-content wrap-color" data-aos="fade-left" data-aos-delay="50" data-aos-duration="500" data-aos-once="true">
                        <span>Why Choose Us</span>
                        <h3>যে জায়গাটিতে Easy English ব্যতিক্রম</h3>
                        <div class="choose-us-inner-box">
                            <div class="icon">
                                <i class="flaticon-ad-campaign"></i>
                            </div>
                            <p>তুমি SSC এর Student হও অথবা  HSC অথবা Admission Test তোমাকে আগে আমরা বেসিকটা ক্লিয়ার করিয়ে নিব এরপর মূল গ্রামারে প্রবেশ করাবো এতে তোমার কাছে English বা অন্যান্য বিষয়টা অত্যন্ত সহজ হয়ে যাবে । কারণ Engish Subject টি কিন্তু Hard নয় এটা Easy একটা সাবজেক্ট কিন্তু সমস্যা হল সামনে Hard Process এর মাধ্যমে উপস্থাপন করা হচ্ছে বিধায় তুমি Hard মনে করছো তুমি আমাদের Process অবলম্বন করো আশা করি তোমার কাছে English Subject টি Easy ই লাগবে । আর তাই তো আমাদের নাম Easy English.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Area -->
@endsection
