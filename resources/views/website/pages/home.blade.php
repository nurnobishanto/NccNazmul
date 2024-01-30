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
                        <span>We Have Worked Across Multiple Industries</span>
                        <h2>Industries We Serve</h2>
                        <p>Successfully delivered digital products Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
            </div>
            <div class="row mt30">
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/house.svg" alt="img"> <h6>Real estate</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/travel-case.svg" alt="img"> <h6>Tour &amp; Travels</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/video-tutorials.svg" alt="img"> <h6>Education</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="0.7s" style="visibility: visible; animation-delay: 0.7s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/taxi.svg" alt="img"> <h6>Transport</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="0.9s" style="visibility: visible; animation-delay: 0.9s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/event.svg" alt="img"> <h6>Event</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="1.1s" style="visibility: visible; animation-delay: 1.1s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/smartphone.svg" alt="img"> <h6>eCommerce</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="1.3s" style="visibility: visible; animation-delay: 1.3s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/joystick.svg" alt="img"> <h6>Game</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="1.5s" style="visibility: visible; animation-delay: 1.5s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/healthcare.svg" alt="img"> <h6>Healthcare</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="1.7s" style="visibility: visible; animation-delay: 1.7s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/money-growth.svg" alt="img"> <h6>Finance</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="1.9s" style="visibility: visible; animation-delay: 1.9s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/baker.svg" alt="img"> <h6>Restaurant</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="2.1s" style="visibility: visible; animation-delay: 2.1s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/mobile-app.svg" alt="img"> <h6>On-Demand</h6> </div></div>
                <div class="col-lg-3 col-sm-6 col-6 wow fadeIn" data-wow-delay="2.3s" style="visibility: visible; animation-delay: 2.3s; animation-name: fadeIn;"> <div class="industry-workfor hoshd"><img src="images/icons/groceries.svg" alt="img"> <h6>Grocery</h6> </div></div></div>
        </div>
    </section>
@endsection
