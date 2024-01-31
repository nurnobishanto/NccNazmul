@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => $course->title,'url'=>'#'])
    <div class="shop-products-bhv pt20 pb60">
        <div class="container">
            <div class="row">

                <div class="col-lg-8">
                    @if($course->image)
                    <div class="rpb-shop-prevw">
                        <img src="{{asset('uploads/'.$course->image)}}" class="w-100" alt="$course->title">
                    </div>
                    @endif
                    @if(enrolledCourse($course))
                    <div class="list-group list-group-horizontal">
                        @if($course->facebook_group)
                        <li class="list-group-item"><a href="{{$course->facebook_group}}" target="blank"><img width="48" src="{{asset('icons/groups.png')}}" alt="Facebook Group"></a></li>
                        @endif
                        @if($course->whatsapp_group_link)
                        <li class="list-group-item"><a href="{{$course->whatsapp_group_link}}" target="blank"><img width="48" src="{{asset('icons/whatsapp.png')}}" alt="Whats App Group"></a></li>
                        @endif
                        @if($course->youtube_playlist)
                        <li class="list-group-item"><a href="{{$course->youtube_playlist}}" target="blank"><img width="48" src="{{asset('icons/youtube.png')}}" alt="Youtube"></a></li>
                        @endif
                        @if($course->meet_link)
                        <li class="list-group-item"><a href="{{$course->meet_link}}" target="blank"><img width="48" src="{{asset('icons/meet.png')}}" alt="Meet"></a></li>
                        @endif
                        @if($course->zoom_link)
                        <li class="list-group-item"><a href="{{$course->zoom_link}}" target="blank"><img width="48" src="{{asset('icons/zoom.png')}}" alt="Zoom"></a></li>
                        @endif
                    </div>
                    @endif
                    <div class="rpb-item-info">
                        <div class="tab-17 tabs-layout">
                            <ul class="nav nav-tabs" id="myTab3" role="tablist">
                            @php  $active = "active"; $true = "true"; @endphp
                            @if($course->details)
                                <li class="nav-item">
                                    <a class="nav-link {{$active}}" id="tab1a" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="{{$true}}">Details</a>
                                </li>
                            @php $active = ""; $true = "false"; @endphp
                            @endif
                            @if($course->modules)
                                <li class="nav-item">
                                    <a class="nav-link  {{$active}}" id="tab2b" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="{{$true}}">Syllabus</a>
                                </li>
                            @php $active = ""; $true = "false"; @endphp
                            @endif
                                <li class="nav-item">
                                    <a class="nav-link" id="tab4c" data-bs-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Support</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent2">
                            @php $active = "active"; $show= "show"; @endphp
                            @if($course->details)
                                <div class="mt20 tab-pane fade {{$active}} {{$show}}" id="tab1" role="tabpanel" aria-labelledby="tab1a">
                                    {!! $course->details !!}
                                </div>
                            @php $active = ""; $show= ""; @endphp
                            @endif
                            @if($course->modules)
                                <div class="tab-pane fade {{$active}} {{$show}}" id="tab2" role="tabpanel" aria-labelledby="tab2b">
                                    <div class="rpb-item-review">
                                        <div class="accordion" id="accordionExample">
                                            @php $collapse = "collapsed"; $show= "show"; @endphp
                                            @foreach($course->modules as $module)

                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-{{$module->id}}">
                                                    <button class="accordion-button {{$collapse}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$module->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                        {{$module->title}}
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{$module->id}}" class="accordion-collapse collapse {{$show}}" aria-labelledby="heading-{{$module->id}}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="data-reqs">
                                                            <div class="niwax-list">
                                                                <ul class="key-points">
                                                                    @foreach($module->items as $item)
                                                                    <li>{{$item->title}}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                @php $collapse = ""; $show= ""; @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @php $active = ""; $show= ""; @endphp
                            @endif

                                <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4c">
                                    <div class="contact-details">
                                        <div class="contact-card wow fadeIn" data-wow-delay=".2s">
                                            <div class="info-card v-center">
                                                <span><i class="fas fa-phone-alt"></i> Phone:</span>
                                                <div class="info-body">
                                                    <p>Assistance hours: Saturday – Thursday, 9 am to 8 pm</p>
                                                    <a href="tel:{{ getSetting('site_phone') }}">{{ getSetting('site_phone') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="email-card mt30 wow fadeIn" data-wow-delay=".5s">
                                            <div class="info-card v-center">
                                                <span><i class="fas fa-envelope"></i> Email:</span>
                                                <div class="info-body">
                                                    <p>Our support team will get back to in 24-h during standard business hours.</p>
                                                    <a href="mailto:{{ getSetting('site_email') }}">{{ getSetting('site_email') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="skype-card mt30 wow fadeIn" data-wow-delay=".9s">
                                            <div class="info-card v-center">
                                                <span><i class="fa fa-map-marker-alt"></i> Address:</span>
                                                <div class="info-body">
                                                    <p>We Are Online: Monday – Friday, 9 am to 5 pm</p>
                                                    <a href="#">{{ getSetting('site_address') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">

                    <div class="rpb-item-infodv">
                        <ul>
                            @if(!enrolledCourse($course))
                            <li class="price">
                                <strong>Price</strong>
                                <div class="nx-rt">
                                    <div class="rpb-itm-pric"> <span class="offer-prz"> {{getSetting('currency')}} {{$course->sale_price - $offer}} </span> <span class="regular-prz">{{getSetting('currency')}} {{$course->regular_price??$course->sale_price}}</span> </div>
                                </div>
                            </li>
                            @endif
                            <li>
                                <strong>Category</strong>
                                <div class="nx-rt">{{$course->category->title??'Deleted'}}</div>
                            </li>
                            <li>
                                <strong>Duration</strong>
                                <div class="nx-rt">{{$course->duration??'Not set yet'}}</div>
                            </li>
                            <li>
                                <strong>Modules</strong>
                                <div class="nx-rt">{{$course->modules->count()??'Not set yet'}}</div>
                            </li>

                            <li>
                                <strong>Class / Items</strong>
                                <div class="nx-rt">{{ $course->modules->flatMap->items->count()??'Not set yet'}}</div>
                            </li>

                            @if($coupon && !enrolledCourse($course))
                            <li>
                                @if($coupon->code??false)
                                <strong>Coupon Applied</strong>
                                <div class="nx-rt">{{$coupon->code}} ({{$coupon->amount}} {{($coupon->type == 'percent')?'%':''}}</span>)</div>
                                @else
                                    <div class="text-danger">{{$coupon}}</div>
                                @endif
                            </li>
                            @endif
                            @if(enrolledCourse($course))
                                <a href="{{route('learn',['slug'=>$course->slug])}}" class="btn-main bg-btn3 lnk w-100 mt10">Continue Learn</a>
                            @else
                            <li>
                                <div class="cart-pg-coupon">
                                    <form action="{{route('course',['slug'=>$course->slug])}}" method="get">
                                        <input type="text" name="code" class="input-text" placeholder="Coupon code">
                                        <button type="submit" class="bg-btn smllbtnn lnk">Apply<span class="circle"></span></button>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <form action="{{route('course_enroll',['id'=>$course->id])}}" method="post">
                                    @csrf
                                    <input name="coupon" class="d-none" value="{{$coupon->code??0}}">
                                    <div class="form-group">
                                        <input class="btn-check" type="radio" name="payment_method" checked value="bkash" id="bkash">
                                        <label for="bkash" class="btn btn-outline-danger">Bkash</label>
                                    </div>
                                    <input class="btn-main bg-btn3 lnk w-100 mt10" type="submit" value="Enroll Now">
                                </form>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="rpb-item-infodv">
                        <div class="contact-details">
                            <div class="contact-card wow fadeIn" data-wow-delay=".2s">
                                <div class="info-card v-center">
                                    <span><i class="fas fa-phone-alt"></i> Phone:</span>
                                    <div class="info-body">
                                        <p>Assistance hours: Saturday – Thursday, 9 am to 8 pm</p>
                                        <a href="tel:{{ getSetting('site_phone') }}">{{ getSetting('site_phone') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="email-card mt30 wow fadeIn" data-wow-delay=".5s">
                                <div class="info-card v-center">
                                    <span><i class="fas fa-envelope"></i> Email:</span>
                                    <div class="info-body">
                                        <p>Our support team will get back to in 24-h during standard business hours.</p>
                                        <a href="mailto:{{ getSetting('site_email') }}">{{ getSetting('site_email') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="skype-card mt30 wow fadeIn" data-wow-delay=".9s">
                                <div class="info-card v-center">
                                    <span><i class="fa fa-map-marker-alt"></i> Address:</span>
                                    <div class="info-body">
                                        <p>We Are Online: Monday – Friday, 9 am to 5 pm</p>
                                        <a href="#">{{ getSetting('site_address') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
