@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => $course->title,'url'=>'#'])
    <section class="pad-tb">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{$course_item->title}}</h5>
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
                        </div>
                        <div class="card-body">
                            @if($course_item && $course_item->status == 'published' && ($course_item->published_at <= date('Y-m-d j:i:s')))

                                @if($course_item->image)
                                    <img class="img-fluid" src="{{asset('uploads/'.$course_item->image)}}" alt="{{$course_item->title}}">
                                @endif
                                @if($course_item->details)
                                <p>{!! $course_item->details !!}</p>
                                @endif

                                @if($course_item->pdf)
                                    <a class="btn-main bg-btn3 mt10" target="_blank" href="{{asset('uploads/'.$course_item->pdf)}}">Download PDF</a>
                                @endif
                                @if($course_item->file)
                                    <a class="btn-main bg-btn2 mt10" target="_blank" href="{{asset('uploads/'.$course_item->file)}}">Download File</a>
                                @endif
                                @if($course_item->url)
                                <a class="btn-main bg-btn1 mt10" target="_blank" href="{{$course_item->url}}">Learn More</a>
                                @endif
                                @if($course_item->youtube_video)
                                <a class="btn-main bg-btn2  mt10" target="_blank" href="{{$course_item->youtube_video}}">Youtube Video</a>
                                @endif
                                @if($course_item->youtube_playlist)
                                <a class="btn-main bg-btn3  mt10" target="_blank" href="{{$course_item->youtube_playlist}}">Youtube Play List</a>
                                @endif
                                @if($course_item->exam_paper_id)
                                <a class="btn-main bg-btn3 mt10" target="_blank" href="{{ route('start', ['id' => $course_item->exam_paper_id]) }}">Take Exam</a>
                                <a class="btn-main bg-btn2 mt10" target="_blank" href="{{ route('results', ['id' => $course_item->exam_paper_id]) }}">See Results</a>
                                @endif
                            @elseif($course_item && $course_item->status == 'published' && $course_item->published_at > date('Y-m-d'))
                                <h4 class="text-center text-success">Publish soon</h4>
                            @elseif($course_item && $course_item->status == 'draft')
                                <h4 class="text-center text-success">Not published yet</h4>
                            @else
                                <h4 class="text-center text-success">Select Item first to learn...</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="accordion" id="accordionExample">
                        @php $collapse = ""; $show= ""; @endphp
                        @foreach($course->modules as $module)
                            @if($course_item && $course_item->course_module_id == $module->id)
                                @php $collapse = "collapsed"; $show= "show"; @endphp
                            @else
                                @php $collapse = ""; $show= ""; @endphp
                            @endif
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
                                                {!! $module->description !!}
                                                <ul class="key-points">
                                                    @foreach($module->items as $item)
                                                        <li><a href="{{route('learn',['slug'=>$course->slug])}}?item={{$item->id}}">{{$item->title}}</a> </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
