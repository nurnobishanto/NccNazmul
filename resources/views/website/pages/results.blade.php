@extends('layouts.master')

@section('content')

    <div class="blog-area ptb-100">
        <div class="container">
            <a class="btn btn-info" href="{{route('rank', ['id' => $id ])}}">See Rank for this Exam</a>
            <a class="btn btn-warning" href="{{route('question', ['id' => $id ])}}">Download Answer</a>


            <div class="row justify-content-center">
                @foreach ($result as $data)
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
                                <a class="btn d-block btn-warning m-1" href="{{route('result', ['result' => $data->id ])}}"> See Attempt</a>
                            </div>
                        </div>
                    </div>

                @endforeach




            </div>
        </div>
    </div>
@endsection
