@extends('layouts.master')
@section('content')
    @include('website.includes.breadcrumb',['title' => 'Latest Notice Board','url'=>'#'])
    <section class="pad-tb">
        <div class="container">
            <div class="accordion" id="accordionExample">
                @if($notices->count())
                    @php $active = "true"; @endphp
                    @php $show = "show"; @endphp
                    @foreach($notices as $notice)
                    <div class="accordion-item active">
                    <h2 class="accordion-header" id="heading-{{$notice->id}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$notice->id}}" aria-expanded="{{$active}}" aria-controls="collapseOne">
                            {{$notice->title}} <small class="badge badge-warning"> #{!! formatDateTime($notice->created_at,false) !!}</small>
                        </button>
                    </h2>
                    <div id="collapse-{{$notice->id}}" class="accordion-collapse collapse {{$show}}" aria-labelledby="heading-{{$notice->id}}" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="data-reqs">
                                <h5 class="pb20">{{$notice->title}}</h5>
                                @if($notice->image)
                                    <a href="{{asset('uploads/'.$notice->image)}}" target="_blank">
                                        <div>
                                            <img class="img-thumbnail" style="max-height: 200px" src="{{asset('uploads/'.$notice->image)}}" alt="{{$notice->title}}">
                                        </div>
                                    </a>

                                @endif
                                <p>{!! $notice->description !!}</p>
                                @if($notice->url)
                                <a href="{{$notice->url}}" class="btn-main" target="_blank">Learn More <i class="fa fa-arrow-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                    @php $active = "false" @endphp
                    @php $show = ""; @endphp
                    @endforeach
                @else
                    <h2 class="text-danger text-center">No notice available</h2>
                @endif
            </div>
            {{ $notices->links('vendor.pagination.niwax') }}
        </div>
    </section>
@endsection


