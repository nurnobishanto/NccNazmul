@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => $course->title,'url'=>'#'])
    <section class="pad-tb">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            @if($course_item && $course_item->status == 'published' && $course_item->published_at < date('Y-m-d'))
                                <h4>{{$course_item->title}}</h4>
                                @if($course_item->details)
                                <p>{!! $course_item->details !!}</p>
                                @endif
                                @if($course_item->image)
                                <img class="img-fluid" src="{{asset('uploads/'.$course_item->image)}}" alt="{{$course_item->title}}">
                                @endif
                                @if($course_item->pdf)
                                <img class="img-fluid" src="{{asset('uploads/'.$course_item->pdf)}}" alt="{{$course_item->title}}">
                                @endif
                                @if($course_item->file)
                                <img class="img-fluid" src="{{asset('uploads/'.$course_item->file)}}" alt="{{$course_item->title}}">
                                @endif
                                @if($course_item->url)
                                <a class="btn-main bg-btn1 mt10" href="{{$course_item->url}}">Learn More</a>
                                @endif
                                @if($course_item->youtube_video)
                                <a class="btn-main bg-btn2  mt10" href="{{$course_item->youtube_video}}">Youtube Video</a>
                                @endif
                                @if($course_item->youtube_playlist)
                                <a class="btn-main bg-btn3  mt10" href="{{$course_item->youtube_playlist}}">Youtube Play List</a>
                                @endif
                                @if($course_item->exam_paper_id)
                                <a class="btn-main bg-btn3 lnk w-100 mt10" href="{{$course_item->exam_paper_id}}">Take Exam</a>
                                @endif
                            @elseif($course_item && $course_item->status == 'published' && $course_item->published_at > date('Y-m-d'))
                                <h4 class="text-center text-success">Publish soon</h4>
                            @elseif($course_item->status == 'draft')
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
