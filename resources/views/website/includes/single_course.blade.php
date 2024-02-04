<div class="col-lg-4">
    <div class="rpb-shop-items-dv s-block mt60">
        @if($course->featured)
          <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-success">New Course
              <span class="visually-hidden">featured</span>
          </span>
        @endif
        <div class="rpb-shop-items-img">
            <a href="{{route('course',['slug' => $course->slug])}}">
                @if($course->image)
                <img src="{{asset('uploads/'.$course->image)}}" class="img-fluid" alt="{{$course->title}}">
                @else
                <img src="{{asset('website')}}/images/shop/item-perview.jpg" class="img-fluid" alt="{{$course->title}}">
                @endif
            </a>
        </div>
        <div class="rpb-shop-items-info">
            <div class="rpb-shop-items-tittl">
                <h3><a href="{{route('course',['slug' => $course->slug])}}">{{$course->title}}</a></h3>
                <p class="tags-itmm">{{$course->category->title??''}}</p>
            </div>

            <div class="rpb-shop-items-flex">
                <div class="rpb-shop-inf-ll">
                    <div class="rpb-itm-pric">
                        @if($course->sale_price)
                        <span class="offer-prz">{{getSetting('currency')}} {{$course->sale_price}}</span>
                        @endif
                        @if($course->regular_price)
                        <span class="regular-prz">{{getSetting('currency')}} {{$course->regular_price}}</span>
                        @endif
                    </div>
{{--                    <div class="rpb-tim-rate">--}}
{{--                        <div class="star-rate">--}}
{{--                            <ul>--}}
{{--                                <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>--}}
{{--                                <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>--}}
{{--                                <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>--}}
{{--                                <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>--}}
{{--                                <li> <a href="javascript:void(0)"><i class="fas fa-star" aria-hidden="true"></i></a> </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="rpb-itm-sale">144 Sales</div>--}}
                </div>

                <div class="rpb-shop-inf-rr">
                    <div class="rpb-shop-flxbt">
                        <a href="{{route('course',['slug' => $course->slug])}}" class="rpb-shop-prev" data-bs-toggle="tooltip" title="View the course">Preview</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
