<!--Start Hero-->
<section class="hero-card-web bg-gradient12 shape-bg3" >
    <div class=" container">
        <div class="row">
            @if(getNotice()->count())
            <div class="col-lg-12">
                <div class="mb10">
                    <h6 style="z-index: 0.001;" class="px-2 position-absolute btn btn-danger" >Headline</h6>
                    <marquee class="text-dark bg-white rounded" >
                        @foreach(getNotice() as $notice)
                            @if($notice->url)
                                <a class="btn btn-warning" href="{{$notice->url}}">{{$notice->title}}</a> {{strip_tags($notice->description)}}
                            @else
                                <a class="btn btn-warning" href="">{{$notice->url}}</a> {{strip_tags($notice->description)}}
                            @endif
                        @endforeach
                    </marquee>
                </div>
            </div>
            @endif
            <div class="col-lg-7 col-md-6">
                <div class="hero-heading-sec">
                    <h2 class="wow fadeIn small" data-wow-delay="0.3s">{!! getSetting('home_page_title') !!}</h2>
                    <p class="wow fadeIn" data-wow-delay="0.6s">{!! getSetting('home_page_description') !!}</p>
                    <a href="{{route('exam')}}" class="niwax-btn2 wow fadeIn" data-wow-delay="0.5s"> Take Exam <i class="fas fa-chevron-right fa-ani"></i></a>
                    <a href="{{route('courses')}}" class="btn-outline" > Courses <i class="fas fa-chevron-right fa-ani"></i></a>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="hero-right-scmm">
                    <div class="hero-service-cards wow fadeInRight" data-wow-duration="2s">
                        <div class="owl-carousel service-card-prb">
                            @foreach(getNotice() as $notice)
                                @if($notice->image)
                                    <div class="service-slide card-bg-a" data-tilt data-tilt-max="10" data-tilt-speed="1000">
                                        @if($notice->url)
                                            <a href="{{$notice->url}}">
                                                <img class="img-fluid"  alt="{{$notice->title}}" src="{{asset('uploads/'.$notice->image)}}" title="{{$notice->title}}">
                                            </a>
                                        @else
                                            <img class="img-fluid"  alt="{{$notice->title}}" src="{{asset('uploads/'.$notice->image)}}" title="{{$notice->title}}">
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Hero-->
