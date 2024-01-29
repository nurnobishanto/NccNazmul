@extends('layouts.master')

@section('content')

    <div class="blog-area ptb-100">
        <div class="container">
            <p><strong class="d-inline btn btn-success" ><?php echo 'Today : ' . date('l, d M Y , h:i A'); ?></strong></p>

            <h2 class="text-center">ALl Exam List for : {{$ecat->name}}</h2>
            <hr>
            <div class="table-responsive mt-5">
                <div class="col-md-3">
                    <div class="form-group border m-2 p-2">
                        <label for="status-filter">Filter by Status</label>
                        <select id="status-filter" class="form-control">
                            <option value="">All Status</option>
                        </select>
                    </div>
                </div>


                <table id="examListTable" class="table table-striped table-bordered table-sm mt-5">
                    <thead>
                    <tr>
                        <th width="8%">SL</th>
                        <th width="15%">Subject</th>
                        <th width="15%">Exam Name</th>
                        <th width="10%">Exam Start</th>
                        <th width="10%">Exam End</th>
                        <th width="15%">Status</th>
                        <th width="12%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ( $examLists as $item)
                        <tr>
                            <td width="4%">{{$item->id}}</td>
                            <td width="15%" class="small">{{$item->subject->name}}</td>
                            <td width="20%" class="small">{{ $item->name }}</td>
                            <td width="16%" class="small">{!! formatDateTime($item->startdate.' '.$item->starttime) !!}</td>
                            <td width="16%" class="small">{!! formatDateTime($item->enddate.' '.$item->endtime) !!}</td>
                            <th width="15%" class="small text-center">
                                @if(isTodayExam($item)) Today @endif
                                @if(isExamRunning($item) ) Running Exam
                                @elseif(isUpcomingExam($item)) Upcoming Exam
                                @elseif(isPreviousExam($item)) Previous Exam @endif
                            </th>
                            <td width="14%" class="small">
                                @if(isExamRunning($item))
                                    <a class="btn btn-danger m-1 d-block"
                                       href="{{ Route('start', ['id' => $item->id]) }}"><i class="ri-play-circle-fill"></i> Start</a>
                                @elseif(isTodayExam($item))
                                    @if(isExamStarted($item))
                                        <a class="btn btn-danger m-1 d-block"
                                               href="{{ Route('start', ['id' => $item->id]) }}"><i class="ri-play-circle-fill"></i> Start</a>
                                    @else
                                        Exam not started yet
                                    @endif

                                @elseif(isUpcomingExam($item))
                                    Exam not started yet
                                @elseif(isPreviousExam($item))
                                    <a class="btn btn-danger m-1 d-block"
                                       href="{{ Route('start', ['id' => $item->id]) }}"><i class="ri-play-circle-fill"></i> Start</a>
                                    <a class="btn btn-info m-1 d-block"   href="{{ Route('results', ['id' => $item->id]) }}"><i class="ri-file-list-3-fill"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
