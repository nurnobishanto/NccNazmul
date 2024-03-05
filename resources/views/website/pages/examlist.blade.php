@extends('layouts.master')

@section('content')
    @include('website.includes.breadcrumb',['title' => 'ALl Exam List for : '.$ecat->name,'url'=>'#'])

    <section class="portfolio-page pad-tb">
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-6">
                    <div class="common-heading pp">

                        <p class="d-inline bg-gradient12 p-2 rounded-pill text-light"><?php echo  date('l, d M Y , h:i A'); ?></p>

                    </div>
                </div>
                <div class="col-lg-6 v-center">
                    <div class="filters">
                        <ul class="filter-menu">
                            <li data-filter="*" class="is-checked">All</li>
                       @php
                            $statusFound = [
                                'today' => false,
                                'running_exam' => false,
                                'upcoming_exam' => false,
                                'previous_exam' => false,
                            ];
                        @endphp
                        
                        @foreach ($examLists as $item)
                            @php
                                $today = isTodayExam($item) && !$statusFound['today'];
                                $runningExam = isExamRunning($item) && !$statusFound['running_exam'];
                                $upcomingExam = isUpcomingExam($item) && !$statusFound['upcoming_exam'];
                                $previousExam = isPreviousExam($item) && !$statusFound['previous_exam'];
                                
                                $statusFound['today'] = $statusFound['today'] || $today;
                                $statusFound['running_exam'] = $statusFound['running_exam'] || $runningExam;
                                $statusFound['upcoming_exam'] = $statusFound['upcoming_exam'] || $upcomingExam;
                                $statusFound['previous_exam'] = $statusFound['previous_exam'] || $previousExam;
                            @endphp
                        @if($today)<li data-filter=".today"> Today</li> @endif
                        @if($runningExam)<li data-filter=".running_exam"> Running Exam</li> @endif
                        @if($upcomingExam)<li data-filter=".upcoming_exam"> Upcoming Exam</li> @endif
                        @if($previousExam)<li data-filter=".previous_exam"> Previous Exam</li> @endif
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row card-list" style="position: relative; height: 1151.5px;">
                <div class="col-lg-4 col-md-6 grid-sizer"></div>
                @foreach ( $examLists as $item)
                    <div class="col-lg-4 col-sm-4 mt40 single-card-item
                                            @if(isTodayExam($item)) today @endif
                                            @if(isExamRunning($item) ) running_exam
                                            @elseif(isUpcomingExam($item)) upcoming_exam
                                            @elseif(isPreviousExam($item)) previous_exam @endif
                            " style="position: absolute; left: 0%; top: 0px;">
                        <div class="service-card-app hoshd">
                            <h4>{{ $item->name }}</h4>
                            <ul class="-service-list mt10">
                                <li> <a href="{{ route('subject', ['slug' => $item->subject->slug]) }}">{{$item->subject->name}}</a> </li>
                                <li> <a href="#">{{$item->questions->count() }} MCQ</a> </li>
                                <li> <a href="#">{{formatDuration($item->duration)}}</a> </li>
                                <li> <a href="#">{{$item->pmark * $item->questions->count()}} Mark</a> </li>
                            </ul>
                            <p></p>
                            <ul class="list-group">
                                <li class="list-group-item"><span class="badge bg-info text-light">Attempt :</span> </li>
                                <li class="list-group-item"><span class="badge bg-success text-light">Start :</span> {!! formatDateTime($item->startdate.' '.$item->starttime,false) !!}</li>
                                <li class="list-group-item"><span class="badge bg-danger text-light-">Start :</span> {!! formatDateTime($item->enddate.' '.$item->endtime,false) !!} </li>

                            </ul>
                            <div class="row">
                                @if(isExamRunning($item))
                                    <div class="col-6">
                                        <a href="{{ Route('start', ['id' => $item->id]) }}" class="mt20 link-prbs text-danger">Start Exam <i class="fas fa fa-arrow-circle-right"></i></a>
                                    </div>
                                @elseif(isTodayExam($item))
                                    @if(isExamStarted($item))
                                        <div class="col-6">
                                            <a href="{{ Route('start', ['id' => $item->id]) }}" class="mt20 link-prbs text-danger">Start Exam <i class="fas fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    @else
                                        <div class="col-6">
                                            <a href="" class="mt20 link-prbs">Exam not started yet</a>
                                        </div>
                                    @endif

                                @elseif(isUpcomingExam($item))
                                    <div class="col-6">
                                        <a href="" class="mt20 link-prbs">Exam not started yet</a>
                                    </div>
                                @elseif(isPreviousExam($item))
                                    <div class="col-6">
                                        <a href="{{ Route('start', ['id' => $item->id]) }}" class="mt20 link-prbs text-danger">Start Exam <i class="fas fa fa-arrow-circle-right"></i></a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ Route('results', ['id' => $item->id]) }}" class="mt20 link-prbs">See Result <i class="fas fa fa-arrow-circle-right"></i></a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $examLists->links('vendor.pagination.niwax') }}
        </div>
    </section>

@endsection
