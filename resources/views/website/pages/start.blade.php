@extends('layouts.master')

@section('content')
    <div class="blog-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $paper->name }}</h5>
                            <p>{!! $paper->description !!}</p>
                        </div>
                        <div class="card-body">
                            <?php
                            $total = $paper->questions->count();
                            $min = $paper->duration % 60;
                            $duration = $min.' Min';
                            $hour = ($paper->duration - $min) / 60;
                            if ($hour){
                                $duration = $hour.' Hour '.$min.' Min';
                            }
                            if($hour>24){
                                $hours = $hour;
                                $hour = $hour % 24;
                                $day = ( $hours-$hour ) / 24;
                                $duration = $day.' Days '.$hour.' Hour '.$min.' Min';
                            }
                            ?>

                            <p> <strong>Duration : {{ $duration }}</strong><br>
                                <span class="text-primary">Total Questions : {{ $total }} </span><br>
                                <span class="text-success">Postive Mark : {{ $paper->pmark }}</span><br>
                                <span class="text-danger">Negative Mark : {{ $paper->nmark }}</span><br>
                                <span class="text-success "><strong> Total Mark : {{ $total }} X {{ $paper->pmark }} =
                            {{ $total * $paper->pmark }} </strong></span></p>
                            @if(session("exam_paper_password_{$paper->id}"))
                                <strong class="text-danger">{{session("exam_paper_password_{$paper->id}")}}</strong><br>
                            @endif

                        </div>
                        <div class="card-footer">
                            @if (date('Y-m-d H:i:s') >= $paper->startdate . ' ' . $paper->starttime)
                                @if (strlen($paper->password)>0)
                                    <form action="{{route('test_pass')}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-8 col-12">
                                                <div class="form-group">
                                                    <input required class="form-control" type="password" placeholder="Password" name="pass">
                                                    <input  type="text" hidden name="id" value="{{$paper->id}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-12 mt-sm-0 mt-2">
                                                <div class="form-group">
                                                    <input type="submit" value="Start" class="form-control btn btn-danger">
                                                </div>
                                            </div>
                                        </div>


                                    </form>

                                @else
                                    <a class="btn btn-danger m-2 p-2" href="{{ Route('test', ['id' => $paper->id]) }}"><i
                                            class="ri-play-circle-fill"></i> Start</a><br>
                                @endif

                            @else
                                <h6 class="text-danger">The test has not started yet. <br> This test will start at <?php
                                                                                                                       $date=date_create($paper->startdate . ' ' . $paper->starttime);
                                                                                                                       echo date_format($date,"l, d M Y h:i a");
                                                                                                                       ?></h6>

                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
