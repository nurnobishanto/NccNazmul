<!--Start Hero-->
<section class="hero-card-web bg-gradient12 shape-bg3" >
    <div class=" container">
        <div class="row align-items-center">
            @if(getNotice()->count())
            <div class="col-lg-12 mbHeadline">
                <div class="mb10">
                    <h6 style="z-index: 1;" class="px-2 position-absolute btn btn-danger" >Headline</h6>
                    <marquee class="text-dark bg-white rounded px-2 btn" >
                        @foreach(getNotice() as $notice)
                            @if($notice->url)
                                <a class="bg-danger text-light p-2" href="{{$notice->url}}">{{$notice->title}}</a> {{--{{strip_tags($notice->description)}} --}}
                            @else
                                 <strong class="bg-danger text-light p-2">{{$notice->title}}</strong> {{strip_tags($notice->description)}}
                            @endif
                        @endforeach
                    </marquee>
                </div>
            </div>
            @endif
            <div class="col-lg-7 col-md-12">
                <div class="hero-heading-sec">
                    <h1 class="wow fadeIn mb-5" style="color: yellow">{!! getSetting('home_page_title') !!}</h1>
                    <h2 class="wow fadeIn" >{!! getSetting('home_page_description') !!}</h2>
                </div>
            </div>
            <div class="col-lg-5 col-md-12">
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
            <div class="col-12 d-flex">
                <a class="m-2" href="{{route('exam')}}"><button  class="niwax-btn3 wow fadeIn"> Take Exam <i class="fas fa-chevron-right fa-ani"></i></button></a>
                <a class="m-2" href="{{route('courses')}}"><button  class="niwax-btn2 wow fadeIn"> Courses <i class="fas fa-chevron-right fa-ani"></i></button></a>
            </div>
        </div>
    </div>
</section>
<!--End Hero-->
