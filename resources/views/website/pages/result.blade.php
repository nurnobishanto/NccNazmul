@extends('layouts.master')

@section('content')
    <div class="blog-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <h1 class="text-center">{{ $data->exam_paper->name }}</h1>
                    <p>{!! $data->exam_paper->description !!}</p>
                </div>
                <div class="col-md-4">
                    <div class="card m-1">
                        <div class="card-header">
                            <h5 class="card-title">Name : {{ $data->user->name }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <tr><th>Full Mark :</th><th>{{ $data->exam_paper->questions->count() * $data->exam_paper->pmark }}</th></tr>
                                <tr><th>Your Mark :</th><th>{{ $data->total_mark }} / {{ $data->exam_paper->questions->count() * $data->exam_paper->pmark }}</th></tr>
                                <tr><th>Attempt :</th><th>{{ $data->ca + $data->wa }}</th></tr>
                                <tr><th>Correct :</th><th>{{ $data->ca }}</th></tr>
                                <tr><th>Wrong :</th><th>{{ $data->wa }}</th></tr>
                                <tr><th>Avoid :</th><th>{{ $data->na }}</th></tr>
                                <tr><th>Submitted :</th><th>{{ date('d M Y, h:m A', strtotime($data->created_at)) }}</th></tr>
                                <tr><th>Duration :</th><th>{{ floor($data->duration / 60) }} Minutes {{ $data->duration % 60 }} Seconds</th></tr>
                                <tr><td colspan="2">{{getResultAttemptDetails($data)}}</td></tr>
                            </table>
                                <div class="progress" style="height: 50px">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width:{{ round(($data->ca * 100) / $data->exam_paper->questions->count())  }}%;">
                                        Correct ({{ round(($data->ca * 100) / $data->exam_paper->questions->count()) }}%)
                                    </div>
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width:{{round(($data->na * 100) / $data->exam_paper->questions->count())  }}%">
                                        Avoid ({{ round(($data->na * 100) / $data->exam_paper->questions->count())  }}%)
                                    </div>
                                    <div class="progress-bar bg-danger " role="progressbar"
                                        style="width:{{ round(($data->wa * 100) / $data->exam_paper->questions->count())  }}%">
                                        Wrong ({{ round(($data->wa * 100) / $data->exam_paper->questions->count()) }}%)
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <a class="btn d-block btn-primary m-1" href="{{ route('resultCardPdf', ['id' => $data->id]) }}"
                               target="_blank" rel="noopener noreferrer"><i class="ri-download-2-line"></i>
                                Download Result Card</a>
                            <a class="btn d-block btn-danger m-1" href="{{route('rank', ['id' => $data->exam_paper->id ])}}">See Rank for this Exam</a>
                            <a class="btn d-block btn-warning m-1" href="{{route('question', ['id' => $data->exam_paper->id ])}}">Download Answer sheet</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">

                    <?php
                    $count = 1;
                    $total = $data->exam_paper->questions->count();
                    $timeMin = $data->exam_paper->duration;
                    $timeSec = $timeMin * 60;

                    ?>
                    <input type="number" name="total" value="{{ $data->exam_paper->questions->count() }}" hidden>
                    <span class="text-dark">Time : {{ $timeMin }} Minutes.</span><br>
                    <span class="text-primary">Total Questions : {{ $total }} </span><br>
                    <span class="text-success">Postive Mark For Every Question : {{ $data->exam_paper->pmark }}</span><br>
                    <span class="text-danger">Negative Mark For Every Question : {{ $data->exam_paper->nmark }}</span><br>
                    <span class="text-success "><strong> Total Mark : {{ $total }} X {{ $data->exam_paper->pmark }} =
                            {{ $total * $data->exam_paper->pmark }} </strong></span><br>
                    <?php $g = [];?>
                    @foreach($data->exam_paper->questions as $q)
                            <?php
                            if (!in_array($q->subject_id, $g)) {
                                array_push($g, $q->subject_id);
                            }

                            ?>
                    @endforeach
                    @foreach($g as $k)
                        <div class="border mt-2 mb-2 p-2">
                            <h4>{{\App\Models\Question::getSubName($k)}}</h4>
                        </div>
                        @foreach ($data->exam_paper->questions->where('subject_id',$k) as $question)
                                @php

                                $cans = $question->ca;
                                $activity = \App\Models\ResultActivity::where('result_id',$data->id)->where('question_id',$question->id)->first();
                                $sans = $activity->attempt;
                                $rowClass = $cans === $sans ? 'border-5 border border-success' : ($sans === 'none' ? ' border-5 border border-warning ' : 'border-5 border border-danger');
                                $textClass = $cans === $sans ? 'text-success' : ($sans === 'none' ? 'text-warning ' : 'text-danger');
                                @endphp
                                <div class="row border m-1 {{ $rowClass }}">
                                    <div>
                                        @if ($question->image)
                                            <div>
                                                <img style="max-height:250px;" src="{{ asset('uploads/'.$question->image) }}"
                                                     alt="{{ $question->name }}">
                                            </div>
                                        @endif
                                        <div>{!! $question->description !!}</div>
                                        <strong>{{$count}}) {{ $question->name }} </strong>
                                    </div>
                                <div class="col-md-6">
                                    <div class="@if($question->$cans == $question->op1) border border-2 border-success @endif @if(($question->$sans == $question->op1) && ($question->$cans == $question->op1) ) bg-success text-light @elseif(($question->$sans == $question->op1) && ($question->$cans != $question->op1)) bg-danger text-light @else bg-light text-dark @endif  rounded p-2 ">
                                        <strong>i) {{ $question->op1 }} </strong>
                                    </div>
                                    <div class="@if($question->$cans == $question->op2) border border-2 border-success @endif  mt-2 @if(($question->$sans == $question->op2) && ($question->$cans == $question->op2)) bg-success text-light @elseif(($question->$sans == $question->op2) && ($question->$cans != $question->op2)) bg-danger text-light @else bg-light text-dark  @endif  rounded p-2 ">
                                        <strong>ii) {{ $question->op2 }} </strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="@if($question->$cans == $question->op3) border border-2 border-success @endif @if(($question->$sans == $question->op3) && ($question->$cans == $question->op3)) bg-success text-light @elseif(($question->$sans == $question->op3) && ($question->$cans != $question->op3)) bg-danger text-light @else bg-light text-dark  @endif  rounded p-2 ">
                                        <strong>iii) {{ $question->op3 }} </strong>
                                    </div>
                                    <div class="@if($question->$cans == $question->op4) border border-2 border-success @endif  mt-2 @if(($question->$sans == $question->op4) && ($question->$cans == $question->op4)) bg-success text-light @elseif(($question->$sans == $question->op4) && ($question->$cans != $question->op4)) bg-danger text-light @else bg-light text-dark  @endif  rounded p-2 ">
                                        <strong>iv) {{ $question->op4 }} </strong>
                                    </div>

                                </div>
                                <strong>
                                    @if($question->$sans)
                                    <span class="{{$textClass}}">Your Answer: {{ $question->$sans }}</span><br>
                                    @else
                                    <span class="{{$textClass}}">You didn't attempt</span>  <br>
                                    @endif
                                    <span class="text-success">Correct Answer: {{ $question->$cans }}</span> <br>
                                </strong>
                                @if($question->explain)
                                <div>Explain : {{$question->explain}}</div>
                                @endif
                                @if($question->explain_img)
                                <img src="{{asset('uploads/'.$question->explain_img)}}" style="max-height:250px;">
                                @endif

                            </div>
                                <?php $count = $count + 1; ?>
                        @endforeach
                    @endforeach



                </div>
            </div>
        </div>
    </div>
@endsection
